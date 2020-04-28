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



def establish_DB_connection():
    # Establishing DB Connectivity

    #Replace the placeholder values with your actual Db2 hostname, username, and password:
    dsn_hostname =  "dashdb-txn-sbox-yp-lon02-04.services.eu-gb.bluemix.net"
    dsn_uid = "xsg48981"
    dsn_pwd = "lm0d2svj^v2fsn15"

    dsn_driver = "{IBM DB2 ODBC DRIVER}"
    dsn_database = "BLUDB"            # e.g. "BLUDB"
    dsn_port = "50000"                # e.g. "50000" 
    dsn_protocol = "TCPIP"            # i.e. "TCPIP"

    #Create database connection
    #DO NOT MODIFY THIS CELL. Just RUN it with Shift + Enter
    dsn = (
        "DRIVER={0};"
        "DATABASE={1};"
        "HOSTNAME={2};"
        "PORT={3};"
        "PROTOCOL={4};"
        "UID={5};"
        "PWD={6};").format(dsn_driver, dsn_database, dsn_hostname, dsn_port, dsn_protocol, dsn_uid, dsn_pwd)

    try:
        conn = ibm_db.connect(dsn, "", "")
        print ("Connected to database: ", dsn_database, "as user: ", dsn_uid, "on host: ", dsn_hostname)
     
    except:
        print ("Unable to connect: ", ibm_db.conn_errormsg() )
        
    print("Connection Successfull");
    return conn


def data_cleaning(text):
    p.set_options(p.OPT.URL, p.OPT.EMOJI, p.OPT.SMILEY)
    text=p.clean(text)
    text=text.lower().replace('.',' ').replace(',',' ').replace('?','').replace('!',' ')
    return text            

def processML(input_text):
    authenticator = IAMAuthenticator('kMIg5T92Ts2PAsmwEQCt7fE8WyBFiUUt-QCyAuD1Ng60')
    natural_language_understanding = NaturalLanguageUnderstandingV1(version='2019-07-12',authenticator=authenticator)
    natural_language_understanding.set_service_url('https://api.eu-de.natural-language-understanding.watson.cloud.ibm.com/instances/19f9b49e-7732-45c5-8b30-0a9be587dcb0')
    response = natural_language_understanding.analyze(text=str(input_text),
    features=Features(entities=EntitiesOptions(sentiment=True,limit=10,model='57cbfcd3-ed32-4cc1-b5f9-72ce8eff4e15'))).get_result()
    #print(json.dumps(response, indent=2))
    max_confidence=0
    entity_type=''
    for entity in response['entities']:
        if entity['type'] in ('EMERGENCY','REQUEST','VOLUNTEER'):
            if entity['confidence'] > max_confidence:
                max_confidence = float(entity['confidence'])
                entity_type = entity['type']
    
    if max_confidence == 0:
        pass
    
    if entity_type == 'EMERGENCY':
        return 'P1'
    elif entity_type == 'REQUEST':
        return 'P2'
    elif entity_type == 'VOLUNTEER':
        return 'P3'
    else:
        return ''

def updateDB(user_name, request_content, latitude, longitude, phone, req_type, conn):

    user_name = user_name
    request_content = request_content
    latitude = latitude
    longitude = longitude
    phone = phone
    req_type = req_type
    
    #Construct the query that retrieves all rows from the REQUESTER table
    ##insert = "insert into requester (USER_NAME, REQ_TEXT, LATITUDE, LONGITUDE, PHONE, REQ_TYPE) VALUES ( 'abanoopb', 'Please provide ambulance service', 21.2212, 23.1234, 8951523243, 'P1')"
    ##ibm_db.exec_immediate(conn,insert)

    insert = "insert into requester (USER_NAME, REQ_TEXT, LATITUDE, LONGITUDE, PHONE, REQ_TYPE) VALUES (?,?,?,?,?,?);"
    #params="( 'abanoopb', 'Please provide ambulance service', 21.2212, 23.1234, 8951523243, 'P1')"
    stmt = ibm_db.prepare(conn, insert)

    ibm_db.bind_param(stmt, 1, user_name)
    ibm_db.bind_param(stmt, 2, request_content)
    ibm_db.bind_param(stmt, 3, latitude)
    ibm_db.bind_param(stmt, 4, longitude)
    ibm_db.bind_param(stmt, 5, phone)
    ibm_db.bind_param(stmt, 6, req_type)
    ibm_db.execute(stmt)

    #Construct the query that retrieves unique id generated from the REQUESTER table    
    stmt = ibm_db.exec_immediate(conn, "SELECT unique SYSIBM.IDENTITY_VAL_LOCAL() AS id FROM requester")
    result = ibm_db.fetch_both(stmt)
    print("Creating Req_ID P00", result[0]);


def disconnect_DB(conn):
    ibm_db.close(conn);
    print("DB Connection successfully disconnected");

#Get Input data from Speech to Text or Twitter

#Clean the data using filtering data

#process the data using process ML

#invokde decision maker functions 
	#Convert the json to python object
	#use the confidance parameter to decide whether it is EMERGENCY request or Request or Volunteer

#Create a custom JSON with name, text, decision, latitude and longitude,phone number

#Use the custom JSON to call the funtion to persist in DB




