import json
from os.path import join, dirname
from ibm_watson import SpeechToTextV1
from ibm_cloud_sdk_core.authenticators import IAMAuthenticator
import ibm_db
from Kernel_IBMHackathon import data_cleaning
from Kernel_IBMHackathon import establish_DB_connection
from Kernel_IBMHackathon import processML
from Kernel_IBMHackathon import updateDB
from Kernel_IBMHackathon import disconnect_DB

authenticator = IAMAuthenticator('J1A-Q3hu7BNoUSfAbRLH2Ia__gh7p7VhQq0sYXRVu6ga')
speech_to_text = SpeechToTextV1(
    authenticator=authenticator
)
speech_to_text.set_service_url('https://api.eu-gb.speech-to-text.watson.cloud.ibm.com/instances/1fd012ca-4f8f-4fa1-a40d-4a335380ae6a')

def speechToText(audioLocation,speech_to_text):
    with open(audioLocation,'rb') as audio_file:
        speech_recognition_results = speech_to_text.recognize(
            audio=audio_file,
            content_type='audio/mpeg',
            smart_formatting=True,
            end_of_phrase_silence_time=2,
            ).get_result()
        return speech_recognition_results

transcriptResult = speechToText("E://IBM_Hackathon//Misc_Folder//WhatsApp Audio 2020-04-27 at 19.00.30.mpeg",speech_to_text)
output = json.loads(json.dumps(transcriptResult, indent=2))
finalTranscript = output['results'][0]['alternatives'][0]['transcript']

text = data_cleaning(finalTranscript)

conn=establish_DB_connection()
request_type = processML(text)
latitude = 22.22
longitude = 22.22
phone_no=None
if request_type != '':
    updateDB('speech_to_text',finalTranscript,latitude,longitude,phone_no,request_type,conn)
disconnect_DB(conn)
