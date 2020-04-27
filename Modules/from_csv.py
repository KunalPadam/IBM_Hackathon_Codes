import pandas as pd
import preprocessor as p
from langdetect import detect_langs
import re
import json
import sys
from ibm_watson import NaturalLanguageUnderstandingV1
from ibm_cloud_sdk_core.authenticators import IAMAuthenticator
from ibm_watson.natural_language_understanding_v1 import Features, EntitiesOptions
import ibm_db
from Kernel_IBMHackathon import data_cleaning
from Kernel_IBMHackathon import establish_DB_connection
from Kernel_IBMHackathon import processML
from Kernel_IBMHackathon import updateDB
from Kernel_IBMHackathon import disconnect_DB

def data_from_CSV():
    conn=establish_DB_connection()
    df=pd.read_csv(sys.argv[1], keep_default_na=False)
    tweets = df.set_index('status_id',drop=False)
    for index,row in tweets.iterrows():
        phone_no=''
        hashtag=[]
        text=str(row['text'])
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
                if phone_no == '': phone_no = None
                latitude = None
                longitude = None
                updateDB(row['screen_name'],str(row['text']),latitude,longitude,phone_no,request_type, conn)
    disconnect_DB(conn)
    
data_from_CSV()
    