# -*- coding: utf-8 -*-
"""
Created on Tue Jul 30 12:05:36 2019

@author: 6066305
"""
from urllib import request
from datetime import datetime
from bs4 import BeautifulSoup
import csv
from selenium.webdriver.support.ui import Select
import pandas as pd
from pandas.io import sql
import mysql.connector
import time 
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver import ActionChains
import dateparser
con = mysql.connector.connect(host="localhost",    # your host, usually localhost
                     user="root",         # your username
                     password="root",  # your password
                     database="bafa")
"""
mysql.connector.connect(host="localhost",    # your host, usually localhost
                     user="root",         # your username
                     password="root",  # your password
                     database="bafa")
"""
"""
def convertYear(x):
    return x[:6] + "20" + x[6:]
df = pd.read_csv("SiteAfocal.csv").drop(columns="Unnamed: 0")
df["DateDebut"]= df["DateDebut"].apply(convertYear)
df["DateFin"] = df["DateFin"].apply(convertYear)
print(df)
df["DateDebut"] = pd.to_datetime(df["DateDebut"], format="%d/%m/%Y")
df["DateFin"] = pd.to_datetime(df["DateFin"], format="%d/%m/%Y")

cursor = con.cursor()

add_row = ("INSERT INTO bafaComp "
              "VALUES (%(DateDebut)s, %(DateFin)s, %(Themes)s, %(Lieu)s, %(Accueil)s, %(infos)s )  ")
for index, row in df.iterrows():
    print(row.to_dict())


con.commit()

"""



def getData():

  
    organismeLiens = []
    browser = webdriver.Chrome()
    browser.get('http://www.formation-animation.com/list/diplome/formation_bafa.html')
    page_source = browser.page_source
    html_content = BeautifulSoup(page_source,'lxml')
    

    for tr in html_content.find_all('tr', attrs={'bgcolor': '#FFFFFF'}):
        dateDebut = []
        
        dateFin = []
        
        themes = []
        
        lieu = []
        
        accueil = []
        
        infos = []
        
        organisme = []
        browser.get(tr.find_all("a")[0]["href"])
              
        page_sources = browser.page_source
        html_contents = BeautifulSoup(page_sources,'lxml')
        for a in html_contents.find_all("a"):
            try:
                if "http://www.formation-animation.com/view.php?job_id=" in a["href"]:
                        browser.get(a["href"])
                        pge_src = browser.page_source
                        html = BeautifulSoup(pge_src, 'lxml')
                        table = html.find_all('td', attrs={'class': 'view'})
                        accueilStr= ""
                        p = 0
                        for text in table:
                            if p >= 0:

                                if p==0:
                                    themes.append(text.getText().strip().split("\n")[0].strip())
                                if p==2:
                                    dateDebut.append(text.getText().strip())
                                elif p==3:
                                    dateFin.append(text.getText().strip())
                                elif p==4:
                                    organisme.append(text.getText().strip())
                                elif p==9:
                                    lieu.append(text.getText().strip().split(" - ")[0])
                            if "Externat".lower() in text.getText().strip().lower():
                                accueilStr += "Externat"
                            if "1/2 pension".lower() in text.getText().strip().lower():
                                accueilStr += "Demi-pension"
                            if "Internat".lower() in text.getText().strip().lower():
                                accueilStr += "Internat"                                
                            p+=1
                            try:
                                if "http://www.formation-animation.com/view.php?company_id=" in a["href"]:
                                    organismeLiens.append(a["href"])
                            except:
                                continue
                        accueil.append(accueilStr)
                        
                        
                        
                        infos.append(a["href"])
                        toCsv = {"DateDebut" : dateDebut, "DateFin" : dateFin, "Themes" : themes, "Lieu" : lieu, "Accueil" : accueil, "infos" : infos, "Organisme" : organisme}

                        cursor = con.cursor()
                    
                        add_row = ("INSERT INTO bafaComp "
                                      "VALUES (%(DateDebut)s, %(DateFin)s, %(Themes)s, %(Lieu)s, %(Accueil)s, %(infos)s, %(Organisme)s )  ")
                        for index, row in pd.DataFrame.from_dict(toCsv).iterrows():
                            print(row.to_dict())
                            cursor.execute(add_row, row.to_dict())
                    
                        con.commit()
            except:
                continue


        browser.get('http://www.formation-animation.com/list/diplome/formation_bafa.html')

        


    browser.quit()

getData()