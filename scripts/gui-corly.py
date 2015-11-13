#!/usr/bin/python
# coding=utf-8
# 
from main_window import Ui_MainForm
from corlyapi import CorlyAPI 
from PyQt4 import QtCore, QtGui
import sys
import threading
import time
from corly_import import send_test

class Concur(threading.Thread):
	def __init__(self, username, password, filename, plugin, project, p_time):
		threading.Thread.__init__(self)
		self.stopped = False
		self.username = username
		self.password = password
		self.filename = filename
		self.plugin = plugin
		self.project = project
		print username+" "+password+" "+filename+" "+plugin+" "+project
		temp_time = p_time.split(':')
		self.sended = False
		self.p_time = QtCore.QTime(int(temp_time[0]), int(temp_time[1]), int(temp_time[2][0:2]))
		self.state = threading.Condition()

	def run(self):
		print self.p_time.toString()
		while not self.stopped:
			curr_time = QtCore.QTime().currentTime()
			if self.p_time.secsTo(curr_time) >= 0:
				if not self.sended:
					send_test(self.username, self.password, self.plugin, self.project, self.filename)
					self.sended = True
			else:
				self.sended = False
			time.sleep(1)

	def stop(self):
		with self.state:
			self.stopped = True
			self.state.notify()  # unblock self if waiting

class TestApp(QtGui.QWidget):
	def __init__(self, parent=None):
		# Запускаем родительский конструктор и присоединяем слоты к методам
		QtGui.QWidget.__init__(self, parent)
		self.ui = Ui_MainForm()
		self.ui.setupUi(self)
		self._connectSlots()
		# Изначально список пуст, так что кнопка удаления не должна работать
		# Сделаем её неактивной
		self.ui.StartButton.setEnabled(False)
		self.ui.StopButton.setEnabled(False)

		self.corly = CorlyAPI()
		self.plugins = []

		self.LoadPlugins()

	def _connectSlots(self):
		# Устанавливаем обработчики сингналов на кнопки
		self.connect(self.ui.StartButton, QtCore.SIGNAL("clicked()"), self._slotStartClicked)
		self.connect(self.ui.StopButton, QtCore.SIGNAL("clicked()"), self._slotStopClicked)
		self.connect(self.ui.PluginBox, QtCore.SIGNAL("currentIndexChanged(const QString&)"), self._slotPluginChanged)
		self.connect(self.ui.FileNameField, QtCore.SIGNAL("textChanged(QString)"), self._slotChangeCheck)
		self.connect(self.ui.ProjectBox, QtCore.SIGNAL("currentIndexChanged(const QString&)"), self._slotChangeCheck)

	def _slotChangeCheck(self, str):
		if len(self.ui.FileNameField.text()) > 0 and self.ui.ProjectBox.currentIndex() > -1 and len(self.ui.UserNameField.text()) > 0 and len(self.ui.PasswordField.text()) > 0:
			self.ui.StartButton.setEnabled(True)
		else:
			self.ui.StartButton.setEnabled(False)

	def _slotStartClicked(self):
		self.ui.StopButton.setEnabled(True)
		self.ui.StartButton.setEnabled(False)
		filename = self.ui.FileNameField.text()
		username = self.ui.UserNameField.text()
		password = self.ui.PasswordField.text()
		plugin = self.ui.PluginBox.itemData(self.ui.PluginBox.currentIndex()).toString()
		project = self.ui.ProjectBox.itemData(self.ui.ProjectBox.currentIndex()).toString()
		p_time = self.ui.TimeSendEdit.time().toString()
		self.thr = Concur(username, password, filename, plugin, project, p_time)
		self.thr.start()

	def _slotStopClicked(self):
		self.ui.StartButton.setEnabled(True)
		self.ui.StopButton.setEnabled(False)
		self.thr.stop()

	def _slotPluginChanged(self, index):
		print self.ui.PluginBox.itemData(self.ui.PluginBox.currentIndex()).toString()
		plugin = self.ui.PluginBox.itemData(self.ui.PluginBox.currentIndex()).toString()

		self.ui.ProjectBox.clear()

		self.corly.get_projects(plugin)
		for project in self.corly.last_response["Result"]:
			self.ui.ProjectBox.addItem(project["Name"], QtCore.QVariant(project["Id"]))

	def LoadPlugins(self):
		self.ui.PluginBox.clear()
		self.corly.get_plugins()
		self.plugins = self.corly.last_response 
		for plugin in self.corly.last_response["Result"]:
			self.ui.PluginBox.addItem(plugin["Name"], QtCore.QVariant(plugin["Id"]))

if __name__=="__main__":
	import sys
	app = QtGui.QApplication(sys.argv)
	wind = TestApp()
	wind.show()
	sys.exit(app.exec_())