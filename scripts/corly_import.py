#!/usr/bin/python

import sys
import requests
import os.path
import json
import time
from corlyapi import CorlyAPI
import tempfile

MB = 1048576


def send_request(req):
    response = json.loads(requests.get(req).text)

    if response['IsValid'] == 'false':
        print response['Errors'][0]
        exit(0)
    else:
        return response


def show_errors(errors):
    for err in errors:
        print err
    exit(0)

def send_test(user_name, password, plugin, project, file_name):
    user = CorlyAPI()

    if os.path.isfile("current.token"):
        t = open("current.token", "r")
        temp_user_name = t.readline()
        temp_time = t.readline()
        if temp_user_name == user_name and (temp_time+3600*24) > time.time():
            user.token = t.readline()
            user.isValid = True
        t.close()
    if not user.isValid:
        if user.auth(user_name, password):
            t = open("current.token", "w")
            t.write("%s\n%s\n%s" % (user_name, user.last_response['Result']['CreationTime'], user.token))
            t.close()
            print "Logged in"
        else:
            for error in user.errors:
                print error
            exit(0)

    f = open(file_name, "r")
    counter = 0
    if os.path.getsize(file_name) > MB:
        temp_folder = tempfile.gettempdir()
        session_id = user.create_upload_session(plugin, project)
        temp_filename = os.path.basename(file_name)
        if session_id:
            while 1:
                data = f.read(MB)
                if data == "":
                    break
                n_file_name = "%s/%s.%d" % (temp_folder, temp_filename, counter)
                out_f = open(n_file_name, "w")
                out_f.write(data)
                out_f.close()
                counter += 1
            print "Start upload: %s" % temp_filename
            for i in range(0, counter):
                n_file_name = "%s/%s.%d" % (temp_folder, temp_filename, i)
                if user.upload_with_session(n_file_name, session_id, i):
                    print "Part %d: OK" % i
                else:
                    print "Part %d: %s" % (i, user.errors[0])
                os.remove(n_file_name)
            if user.end_upload_session(session_id):
                print "Upload finished Successful"
            else:
                print show_errors(user.errors)
        else:
            print show_errors(user.errors)
    else:
        print "Start upload: %s" % file_name
        if user.upload(plugin, project, file_name):
                print "Upload finished Successful"
        else:
                print show_errors(user.errors)

if __name__== "__main__":
    user_name = sys.argv[1]
    password = sys.argv[2]
    plugin = sys.argv[3]
    project = sys.argv[4]
    file_name = sys.argv[5]
    send_test(user_name, password, plugin, project, file_name)
