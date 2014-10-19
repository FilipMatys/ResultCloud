#!/usr/bin/python

import json
import requests


class CorlyAPI:
    URL = "http://corly-verifit.rhcloud.com/method/"
    token = ""
    isValid = False
    errors = list()
    last_response = dict()

    def auth(self, username, password):
        resp = self.send_request("auth", "login", {"username": username, "password": password})
        if resp['IsValid']:
            self.token = resp['Result']['TokenKey']
        return self.check_valid(resp)

    def create_upload_session(self, plugin, project):
        resp = self.send_request("import", "start", {"plugin": plugin, "project": project, "token_key": self.token})
        if self.check_valid(resp):
            return resp['Result']['SessionId']
        else:
            return False

    def end_upload_session(self, session_id):
        resp = self.send_request("import", "end", {"sessionid": session_id})
        return self.check_valid(resp)

    def upload(self, plugin, project, filename):
        return self.upload_base({"plugin": plugin, "project": project, "token_key": self.token}, filename)

    def upload_with_session(self, filename, session_id, part):
        return self.upload_base({"sessionid": session_id, "part": part}, filename)

    def upload_base(self, params, filename):
        resp = self.send_file(params, filename)
        return self.check_valid(resp)

    def send_request(self, method, function, params):
        str_values = "&".join(["%s=%s" % (k, v) for k, v in params.items()])
        request = "%s%s.%s?%s" % (self.URL, method, function, str_values)

        resp = json.loads(requests.get(request).text)
        return resp

    def send_file(self, params, filename):
        str_values = "&".join(["%s=%s" % (k, v) for k, v in params.items()])
        files = {'file': open(filename, 'rb')}
        request = "%simport.upload?%s" % (self.URL, str_values)
        resp = requests.post(request, files=files).json()

        return resp

    def check_valid(self, resp):
        self.last_response = resp
        if not resp['IsValid']:
            self.errors = resp['Errors']

        self.isValid = resp['IsValid']
        return self.isValid