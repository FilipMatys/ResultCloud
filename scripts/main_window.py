# -*- coding: utf-8 -*-

# Form implementation generated from reading ui file 'main_window.ui'
#
# Created: Wed Sep 30 18:07:20 2015
#      by: PyQt4 UI code generator 4.10.4
#
# WARNING! All changes made in this file will be lost!

from PyQt4 import QtCore, QtGui

try:
    _fromUtf8 = QtCore.QString.fromUtf8
except AttributeError:
    def _fromUtf8(s):
        return s

try:
    _encoding = QtGui.QApplication.UnicodeUTF8
    def _translate(context, text, disambig):
        return QtGui.QApplication.translate(context, text, disambig, _encoding)
except AttributeError:
    def _translate(context, text, disambig):
        return QtGui.QApplication.translate(context, text, disambig)

class Ui_MainForm(object):
    def setupUi(self, MainForm):
        MainForm.setObjectName(_fromUtf8("MainForm"))
        MainForm.setWindowModality(QtCore.Qt.ApplicationModal)
        MainForm.resize(344, 265)
        sizePolicy = QtGui.QSizePolicy(QtGui.QSizePolicy.Fixed, QtGui.QSizePolicy.Fixed)
        sizePolicy.setHorizontalStretch(0)
        sizePolicy.setVerticalStretch(0)
        sizePolicy.setHeightForWidth(MainForm.sizePolicy().hasHeightForWidth())
        MainForm.setSizePolicy(sizePolicy)
        MainForm.setMaximumSize(QtCore.QSize(101010, 101010))
        MainForm.setMouseTracking(True)
        MainForm.setFocusPolicy(QtCore.Qt.TabFocus)
        MainForm.setContextMenuPolicy(QtCore.Qt.NoContextMenu)
        self.verticalLayoutWidget = QtGui.QWidget(MainForm)
        self.verticalLayoutWidget.setGeometry(QtCore.QRect(2, 0, 341, 265))
        self.verticalLayoutWidget.setObjectName(_fromUtf8("verticalLayoutWidget"))
        self.verticalLayout = QtGui.QVBoxLayout(self.verticalLayoutWidget)
        self.verticalLayout.setSizeConstraint(QtGui.QLayout.SetMaximumSize)
        self.verticalLayout.setMargin(0)
        self.verticalLayout.setObjectName(_fromUtf8("verticalLayout"))
        self.formLayout = QtGui.QFormLayout()
        self.formLayout.setObjectName(_fromUtf8("formLayout"))
        self.UserNameLabel = QtGui.QLabel(self.verticalLayoutWidget)
        self.UserNameLabel.setObjectName(_fromUtf8("UserNameLabel"))
        self.formLayout.setWidget(0, QtGui.QFormLayout.LabelRole, self.UserNameLabel)
        self.UserNameField = QtGui.QLineEdit(self.verticalLayoutWidget)
        self.UserNameField.setObjectName(_fromUtf8("UserNameField"))
        self.formLayout.setWidget(0, QtGui.QFormLayout.FieldRole, self.UserNameField)
        self.PasswordLabel = QtGui.QLabel(self.verticalLayoutWidget)
        self.PasswordLabel.setObjectName(_fromUtf8("PasswordLabel"))
        self.formLayout.setWidget(1, QtGui.QFormLayout.LabelRole, self.PasswordLabel)
        self.PasswordField = QtGui.QLineEdit(self.verticalLayoutWidget)
        self.PasswordField.setObjectName(_fromUtf8("PasswordField"))
        self.PasswordField.setEchoMode(self.PasswordField.Password)
        self.formLayout.setWidget(1, QtGui.QFormLayout.FieldRole, self.PasswordField)
        self.PluginLabel = QtGui.QLabel(self.verticalLayoutWidget)
        self.PluginLabel.setObjectName(_fromUtf8("PluginLabel"))
        self.formLayout.setWidget(2, QtGui.QFormLayout.LabelRole, self.PluginLabel)
        self.PluginBox = QtGui.QComboBox(self.verticalLayoutWidget)
        self.PluginBox.setObjectName(_fromUtf8("PluginBox"))
        self.formLayout.setWidget(2, QtGui.QFormLayout.FieldRole, self.PluginBox)
        self.ProjectLabel = QtGui.QLabel(self.verticalLayoutWidget)
        self.ProjectLabel.setObjectName(_fromUtf8("ProjectLabel"))
        self.formLayout.setWidget(3, QtGui.QFormLayout.LabelRole, self.ProjectLabel)
        self.ProjectBox = QtGui.QComboBox(self.verticalLayoutWidget)
        self.ProjectBox.setObjectName(_fromUtf8("ProjectBox"))
        self.formLayout.setWidget(3, QtGui.QFormLayout.FieldRole, self.ProjectBox)
        self.TimeLabel = QtGui.QLabel(self.verticalLayoutWidget)
        self.TimeLabel.setObjectName(_fromUtf8("TimeLabel"))
        self.formLayout.setWidget(4, QtGui.QFormLayout.LabelRole, self.TimeLabel)
        self.TimeSendEdit = QtGui.QTimeEdit(self.verticalLayoutWidget)
        self.TimeSendEdit.setObjectName(_fromUtf8("TimeSendEdit"))
        self.formLayout.setWidget(4, QtGui.QFormLayout.FieldRole, self.TimeSendEdit)
        self.FileLabel = QtGui.QLabel(self.verticalLayoutWidget)
        self.FileLabel.setObjectName(_fromUtf8("FileLabel"))
        self.formLayout.setWidget(5, QtGui.QFormLayout.LabelRole, self.FileLabel)
        self.FileNameField = QtGui.QLineEdit(self.verticalLayoutWidget)
        self.FileNameField.setObjectName(_fromUtf8("FileNameField"))
        self.formLayout.setWidget(5, QtGui.QFormLayout.FieldRole, self.FileNameField)
        self.verticalLayout.addLayout(self.formLayout)
        self.StartButton = QtGui.QPushButton(self.verticalLayoutWidget)
        self.StartButton.setObjectName(_fromUtf8("StartButton"))
        self.verticalLayout.addWidget(self.StartButton)
        self.StopButton = QtGui.QPushButton(self.verticalLayoutWidget)
        self.StopButton.setObjectName(_fromUtf8("StopButton"))
        self.verticalLayout.addWidget(self.StopButton)

        self.retranslateUi(MainForm)
        QtCore.QMetaObject.connectSlotsByName(MainForm)

    def retranslateUi(self, MainForm):
        MainForm.setWindowTitle(_translate("MainForm", "Test Send Manager", None))
        self.UserNameLabel.setText(_translate("MainForm", "Username:", None))
        self.PasswordLabel.setText(_translate("MainForm", "Password:", None))
        self.PluginLabel.setText(_translate("MainForm", "Choose Plugin:", None))
        self.ProjectLabel.setText(_translate("MainForm", "Choose Project:", None))
        self.TimeLabel.setText(_translate("MainForm", "Set Import Time:", None))
        self.FileLabel.setText(_translate("MainForm", "Set File Name:", None))
        self.StartButton.setText(_translate("MainForm", "Start", None))
        self.StopButton.setText(_translate("MainForm", "Stop", None))

