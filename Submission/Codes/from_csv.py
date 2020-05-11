# coding=utf8
import pandas as pd
import preprocessor as p
import json
from langdetect import detect_langs
import re
import sys
from Kernel_IBMHackathon import data_cleaning
from Kernel_IBMHackathon import establish_DB_connection_SQL
from Kernel_IBMHackathon import processML
from Kernel_IBMHackathon import updateDB_SQL
from Kernel_IBMHackathon import disconnect_DB_SQL
from ibm_watson import LanguageTranslatorV3
from ibm_cloud_sdk_core.authenticators import IAMAuthenticator

def data_from_CSV():
    conn=establish_DB_connection_SQL()
    df=pd.read_csv(sys.argv[1], keep_default_na=False)
    tweets = df.set_index('status_id',drop=False)
    for index,row in tweets.iterrows():
        phone_no=''
        hashtag=[]
        text=str(row['text'])
        
        if str(detect_langs(text)[0])[0:2] == 'hi' and text!='nan':
            text1=text
            authenticator = IAMAuthenticator('worUzb_Eb5emCaIs0oL7sR86Fb2LeTJGOk1EN1Q-4Cni')
            language_translator = LanguageTranslatorV3(version='2018-05-01',authenticator=authenticator)
            
            language_translator.set_service_url('https://api.eu-gb.language-translator.watson.cloud.ibm.com/instances/cdafbc7e-b59a-40f8-818f-1914f02063cc')
            translation = language_translator.translate(text=text1,model_id='hi-en').get_result()
            output=json.loads(json.dumps(translation, indent=2, ensure_ascii=False))
            text=output['translations'][0]['translation']
        
        if str(detect_langs(text)[0])[0:2] == 'en' and text!='nan':
            text = data_cleaning(text)
            words=text.split()
            words=set(words)
            words=list(words)
            for w in words:
                if re.match('^((\+){0,1}91(\s){0,1}(\-){0,1}(\s){0,1}){0,1}0{0,1}[1-9]{1}[0-9]{9}$',w):
                    phone_no = w[-10:]
                if w.startswith('#'):
                    hashtag.append(w)
            request_type = processML(text)
            
            if request_type != '':
                name=str(row['screen_name'])
                if name == '': name = None
                if text == '': text = None
                if phone_no == '': phone_no = 9900990099
                latitude = 9.9252
                longitude = 78.1198
                updateDB_SQL(row['screen_name'],text,latitude,longitude,phone_no,request_type, conn)
    disconnect_DB_SQL()
    
data_from_CSV()
    