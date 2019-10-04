# -*- coding: utf-8 -*-
"""
Created on Wed Oct  2 15:19:29 2019

@author: MS42
"""

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
con = mysql.connector.connect(host="localhost",    # your host, usually localhost
                     user="root",         # your username
                     password="root",  # your password
                     database="bafa")
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



def getDataAfocal():
    dateDebut = []
    
    dateFin = []
    
    dates = []
    
    themes = []
    
    lieu = []
    
    accueil = []
    
    infos = []
    
    dico_values = {"AG" : "Générale", "AA": "Approfondissement", "AQ" : "Qualification"}
    for value, type in dico_values.items(): 
    
        def getAll(url, browser):
            rege_url = "https://www.afocal.fr/bafa/" + url
            browser.get(rege_url)
            
    
            
            pages = browser.page_source
            soup = BeautifulSoup(pages, 'lxml')
            for tr in soup.find_all('tr')[2:]:
                tds = tr.find_all('td')
                
                lieu.append(tds[1].text.split("(")[0])
                dateDebut.append(tds[2].text[3:11])
                dateFin.append(tds[2].text[14:22])
    
                accueil.append(tds[3].text.split(":")[0])
                if (value == "AG"):
                    themes.append("General")
                else:
                    themes.append(tds[0].text)
                infos.append("https://www.afocal.fr/bafa/" + str(tds[4]).split('"')[3])        
        browser = webdriver.Chrome()
        browser.get('https://www.afocal.fr/bafa/recherche-bafa-0-1.html')
        select = Select(browser.find_element_by_id('sel_type'))
    
        select.select_by_value(value)
        browser.execute_script("document.forms[0].submit();")
    
        page = browser.page_source
        
        # parse the html using beautifulsoup
        html_content = BeautifulSoup(page, 'html.parser')
    
        html_contents = html_content.find('div', attrs={'id': 'tablo'})
        for tr in html_contents.find_all('tr')[2:]:
                tds = tr.find_all('td')
                lieu.append(tds[1].text.split("(")[0])
                dateDebut.append(tds[2].text[3:11])
                dateFin.append(tds[2].text[14:22])
    
                accueil.append(tds[3].text.split(":")[0])
                if (value == "AG"):
                    themes.append("General")
                else:
                    themes.append(tds[0].text)
                infos.append("https://www.afocal.fr/bafa/" + str(tds[4]).split('"')[3])    
        pages = html_content.find('div', attrs={'class': 'pages'})
        
        for element in str(pages).split('"'):
                if "recherche" in element:
                    getAll(str(element),browser)
    
        browser.quit()
    toCsv = {"DateDebut" : dateDebut, "DateFin" : dateFin, "Themes" : themes, "Lieu" : lieu, "Accueil" : accueil, "infos" : infos}

    cursor = con.cursor()

    add_row = ("INSERT INTO bafaComp "
                  "VALUES (%(DateDebut)s, %(DateFin)s, %(Themes)s, %(Lieu)s, %(Accueil)s, %(infos)s )  ")
    for index, row in pd.DataFrame.from_dict(toCsv).iterrows():
        print(row.to_dict())
        cursor.execute(add_row, row.to_dict())

    con.commit()
#générer les fichier s utiles
def getDataBafaBafd():

    browser = webdriver.Chrome()
    browser.get('http://bafa-bafd-foyersruraux.org/trouver-son-stage-de-formation')
    
    browser.execute_script("lancer_recherche();")
    
    page_source = browser.page_source
    browser.quit()
    html_content = BeautifulSoup(page_source,'lxml')
    
    dates = html_content.find_all('li', attrs={'class': 'col bafad-periode mobile-only'})
    for i in range(len(dates)):
        dates[i] = dates[i].text.replace('Dates','')
        
    themes = html_content.find_all('li', attrs={'class': 'col bafad-theme'})
    for i in range(len(themes)):
        themes[i] = themes[i].text.replace('Thématique','')

    lieu = html_content.find_all('li', attrs={'class': 'col bafad-lieu'})
    for i in range(len(lieu)):
        lieu[i] = lieu[i].text.replace('Lieu','')
    
    accueil = html_content.find_all('li', attrs={'class': 'col bafad-accueil'})

    for i in range(len(accueil)):
        accueil[i] = accueil[i].text.replace('Accueil','')
    
        
    infos = html_content.find_all('li', attrs={'class': 'col bafad-infos'})
    
    for i in range(len(infos)):
        if (len(str(infos[i]).split('"'))>3):
            infos[i] = "http://bafa-bafd-foyersruraux.org/" + str(infos[i]).split('"')[3]

    toCsv = {"Date" : dates, "Themes" : themes[1:], "Lieu" : lieu[1:], "Accueil" : accueil[1:], "infos" : infos[1:]}
    import pandas as pd
    print(toCsv)
    #pd.DataFrame.from_dict(toCsv).to_csv("SiteBafaBafd.csv", encoding="utf-8")

def getDataLeoLagrange():
    dates = []
    
    themes = []
    
    lieu = []
    
    accueil = []
    
    infos = []
    
    browser = webdriver.Chrome()
    browser.get('https://www.bafa-bafd.org/formation/?region=12&saison=&type=1')
    i = 1
    while 1:
        try:
            browser.execute_script("javascript:clickering(" + str(i) + ");")
            page_source = browser.page_source
            html_content = BeautifulSoup(page_source,'lxml')
                        
            j = 0
            for tr in html_content.find_all('tr')[1:]:
                try:
                    tds = tr.find_all('td')
                    lieu.append(tds[2].text)
                    dates.append(tds[0].text)
                    accueil.append(tds[3].text)
                    themes.append(tds[1].text)
                    infos.append("https://www.bafa-bafd.org/" + str(tds[5]).split('"')[3])
                    j+=1
                except:
                    continue
            i+=1
            if j==0:
                break
        except:
            break
    toCsv = {"Date" : dates, "Themes" : themes, "Lieu" : lieu, "Accueil" : accueil, "infos" : infos}
    import pandas as pd
    
    pd.DataFrame.from_dict(toCsv).to_csv("SiteLeoLagrange.csv", encoding="utf-8")
    browser.quit()

def getDataFnfr():

    dates = []
    
    themes = []
    
    lieu = []
    
    accueil = []
    
    infos = []
    
    browser = webdriver.Chrome()
    i = 1
    while 1:

            browser.get('http://www.ma-formation-bafa.fr/Resultat_Recherche.php?formation=tous&periode=tous&region=18&arbo=2&row_arbo_principal=&row_arbo=Accueil&val_formation=&val_periode=&val_region=&periodetext=Toutes&page='+str(i)+"&tri="+str(i))
  
            page_source = browser.page_source
            html_content = BeautifulSoup(page_source,'lxml')
                        
            j = 0
            for tr in html_content.find_all('tr')[1:]:
                try:
                    ths = tr.find_all('th')[0].find_all('span')
                    
                    tds = tr.find_all('td')
                    accueiltext = ""
                    if (len(str(tds[0].text))>2):
                        accueiltext += "Internat "
                    if (len(str(tds[1].text))>2):
                        accueiltext += "Demi-pension "
                    if (len(str(tds[2].text))>2):
                        accueiltext += "Externat "
                    lieu.append(ths[2].text)
                    dates.append(ths[1].text)
                    accueil.append(accueiltext)                   
                    themes.append(ths[0].text)
                    infos.append("http://www.ma-formation-bafa.fr/" + str(tds[3]).split('"')[3])
                    j+=1
                except:
                    continue
            i+=1
            if j==0:
                break

    toCsv = {"Date" : dates, "Themes" : themes, "Lieu" : lieu, "Accueil" : accueil, "infos" : infos}
    import pandas as pd
    print(toCsv)
    #pd.DataFrame.from_dict(toCsv).to_csv("SiteFnfr.csv", encoding="utf-8")
    browser.quit()   
    
def atcRouteDuMonde():
    dates = []
    
    themes = []
    
    lieu = []
    
    accueil = []
    
    infos = []
    
    browser = webdriver.Chrome()
    i = 1

    browser.get('https://www.atc-routesdumonde.com/formations-bafa-bafd/calendrier-des-sessions/bafa-formation-generale/')
  
    page_source = browser.page_source
    html_content = BeautifulSoup(page_source,'lxml')
    text = html_content.find_all(text=True)
    

    for i in range(len(text)):
        try:
            if "du" in text[i].lower() and "au" in text[i].lower() and len(text[i]) < 150 :
                p = 0
                for j in range(15):
                    if len(set(text[i+j])) > 3:
                        if p == 0:
                            dates.append(text[i+j])
                        elif p == 1:
                            lieu.append(text[i+j])
                        elif p == 2:
                            accueil.append(text[i+j][1:])
                        elif p == 3:
                            themes.append("General")
                            
                        p+=1
                infos.append("https://www.atc-routesdumonde.com/formations-bafa-bafd/contact-brochure-devis/")


        except:
            continue


    browser.get('https://www.atc-routesdumonde.com/formations-bafa-bafd/calendrier-des-sessions/approfondissement-et-qualification/')
    
    page_source = browser.page_source
    html_content = BeautifulSoup(page_source,'lxml')
    text = html_content.find_all(text=True)
    

    for i in range(len(text)):
        try:
            if "du" in text[i].lower() and "au" in text[i].lower() and len(text[i]) < 150 :
                p = 0
                for j in range(15):
                    print(text[i+j])
                    if len(set(text[i+j])) > 3:
                        if p == 0:
                            dates.append(text[i+j])
                        elif p == 1:
                            themes.append(text[i+j])
                            
                        elif p == 2:
                            lieu.append(text[i+j][1:])

                        elif p == 3:
                            accueil.append(text[i+j][1:])
                            
                        p+=1
                infos.append("https://www.atc-routesdumonde.com/formations-bafa-bafd/contact-brochure-devis/")


        except:
            continue

    
    toCsv = {"Date" : dates, "Themes" : themes, "Lieu" : lieu, "Accueil" : accueil, "infos" : infos}
    import pandas as pd
    print(toCsv)
    #pd.DataFrame.from_dict(toCsv).to_csv("SiteFnfr.csv", encoding="utf-8")
    browser.quit()   
    
    
def assoCfag():
    dates = []
    
    themes = []
    
    lieu = []
    
    accueil = []
    
    infos = []
    
    browser = webdriver.Chrome()
    i = 0

    
    while 1 :
        browser.get('http://www.asso-cfag.com/stages/bafa/?page=' + str(i))

        page_source = browser.page_source
        html_content = BeautifulSoup(page_source,'lxml')
                        
        
        for element in html_content.find_all('div', attrs={'class': 'columns mb25'}):
            j = 0
            for text in element.find_all(text=True):
                if len(text) > 3:
                    if j==0:
                        themes.append(text)
                    if j==3:
                        if (len(text.split(","))>=4):
                            lieu.append(text.split(",")[3])
                        else:
                            lieu.append(text.split(",")[0])
                    if j==4:
                        dates.append(text)
                    j+=1
            for link in element.find_all('a'):
                infos.append(link["href"])
            accueil.append("Non renseigné")
        if len( html_content.find_all('div', attrs={'class': 'columns mb25'})) == 0:
            break
        i+=1
        """
        <div class="columns mb25">
				<div id="post-6548" class="course-post post-6548 course type-course status-publish hentry course_cat-bafa course_cat-qualification-surveillant-de-baignade thematic-surveillant-de-baignade" data-maps-posts="" data-place="Lycée" data-address="" data-postcode="29200" data-city="Brest">
	<div class="row">
		<div class="medium-12 small-6 columns">
			<a href="http://www.asso-cfag.com/stage/qualification-surveillant-de-baignade-51/"><img src="http://www.asso-cfag.com/wp-content/themes/cfag/assets/images/default/default-post.jpg" alt="Qualification surveillant de baignade"></a>		</div>
		<div class="medium-12 small-6 columns">
			<header>
				<h2><a href="http://www.asso-cfag.com/stage/qualification-surveillant-de-baignade-51/">Qualification surveillant de baignade</a></h2>
			</header>
		</div>
		<div class="small-12 columns">
			<div class="entry-content">
				<div class="course_info icon-ribbon">
					<div>
					BAFA - Qualification surveillant de baignade					</div>
				</div>
				<div class="course_info icon-map">
					<div>Finistère</div>
					<div>Lycée, , 29200, Brest</div>
				</div>	
				<div class="course_info icon-date">
					<div>Toussaint - du 19/10/2019 au 26/10/2019</div>
				</div>
				
				<a href="http://www.asso-cfag.com/stage/qualification-surveillant-de-baignade-51/" class="button tiny float-right mb20">Plus d'infos</a>
        """
    
    
    toCsv = {"Date" : dates, "Themes" : themes, "Lieu" : lieu, "Accueil" : accueil, "infos" : infos}
    import pandas as pd
    print(toCsv)
    #pd.DataFrame.from_dict(toCsv).to_csv("SiteFnfr.csv", encoding="utf-8")
    browser.quit()   
    
def scoutismeFrancais():
    
    dates = []
    
    themes = []
    
    lieu = []
    
    accueil = []
    
    infos = []
    
    browser = webdriver.Chrome()
    i = 0

    regions = ['https://www.scoutisme-francais.fr/formation/bourgogne-franche-comte', 
               'https://www.scoutisme-francais.fr/formation/hauts-de-france', 
               'https://www.scoutisme-francais.fr/formation/bretagne', 
               'https://www.scoutisme-francais.fr/formation/ile-de-france', 
               'https://www.scoutisme-francais.fr/formation/pays-de-la-loire', 
               'https://www.scoutisme-francais.fr/Formation/grand-est', 
               'https://www.scoutisme-francais.fr/formation/normandie', 
               'https://www.scoutisme-francais.fr/formation/Auvergne-Rhone-Alpes', 
               'https://www.scoutisme-francais.fr/Formation/Provence-Alpes-Cote-dAzur', 
               'https://www.scoutisme-francais.fr/formation/corse',
               'https://www.scoutisme-francais.fr/formation/occitanie', 
               'https://www.scoutisme-francais.fr/formation/centre-val-de-loire',
               'https://www.scoutisme-francais.fr/formation/nouvelle-aquitaine']
    for link in regions:    
        browser.get(link)
        time.sleep(3) 
        page_source = browser.page_source
        html_content = BeautifulSoup(page_source,'lxml')
        for element in html_content.find_all('div', attrs={'class': 'ag-row ag-row-no-focus ag-row-even ag-row-level-0'})[1:]:
            j = 0

            if (len(element.text)>0 and "BAFD" not in element.text):
                stri =  element.text
                stri = stri.replace("Scouts et Guides De France", "")
                stri = stri.replace("Eclaireuses Eclaireurs de France", "")
                if "Formation d’approfondissement" in stri:
                    themes.append("Formation d’approfondissement BAFA")
                    dates.append(stri[34:54])
                    
                    lieu.append(stri[54:])
                    accueil.append("Non renseigné")
                    infos.append("https://www.scoutisme-francais.fr/formation/bafa")
                else:
                    themes.append("Formation générale BAFA")
                    dates.append(stri[23:43])
                    lieu.append(stri[43:])
                    accueil.append("Non renseigné")
                    infos.append("https://www.scoutisme-francais.fr/formation/bafa")                   
                print(dates)
                print(lieu)
    toCsv = {"Date" : dates, "Themes" : themes, "Lieu" : lieu, "Accueil" : accueil, "infos" : infos}
    import pandas as pd
    print(toCsv)
    #pd.DataFrame.from_dict(toCsv).to_csv("SiteFnfr.csv", encoding="utf-8")
    browser.quit()  
    
def CEMEA():
    
    dates = []
    
    themes = []
    
    lieu = []
    
    accueil = []
    
    infos = []
    
    browser = webdriver.Chrome()
    i = 0


    browser.get("https://cemea-formation.com/f/bafa/")

    slider = browser.find_element_by_id("slider-radius")
    width = slider.size['width']
    print(width)
    move = ActionChains(browser)
    move.click_and_hold(slider).move_by_offset(0,0).release().perform()
    move.click_and_hold(slider).move_by_offset(180,0).release().perform()
    time.sleep(1)

    moreLoaded = False
    # click submit button
    while moreLoaded == False:
        try:
            submit_button = browser.find_element_by_id('more')
            submit_button.click()
            time.sleep(1)

        except:
            moreLoaded = True
    page_source = browser.page_source
    html_content = BeautifulSoup(page_source,'lxml')
    for typeFormation in html_content.find_all('span', attrs={'class': 'type'})[1:]:
        themes.append(typeFormation.text)
    for ville in html_content.find_all('span', attrs={'class': 'ville'})[1:]:
        lieu.append(ville.text)
    for date in html_content.find_all('span', attrs={'class': 'date'})[1:]:
        dates.append(date.text)
    for a in html_content.find_all('a', attrs={'class': 'pure-button pure-button-primary'})[1:]:
        infos.append("https://cemea-formation.com/f/bafa" + a["href"])
        accueil.append("Non renseigné")

    submit_button = browser.find_elements_by_xpath("//a[@class='swipe-next arrow']")[0]
    submit_button.click()
    time.sleep(1)


    slider = browser.find_element_by_id("slider-radius")
    width = slider.size['width']
    print(width)
    move = ActionChains(browser)
    move.click_and_hold(slider).move_by_offset(0,0).release().perform()
    move.click_and_hold(slider).move_by_offset(180,0).release().perform()
    time.sleep(1)

    moreLoaded = False
    # click submit button
    while moreLoaded == False:
        try:
            submit_button = browser.find_element_by_id('more')
            submit_button.click()
            time.sleep(1)

        except:
            moreLoaded = True
    page_source = browser.page_source
    html_content = BeautifulSoup(page_source,'lxml')
    for typeFormation in html_content.find_all('span', attrs={'class': 'type'})[1:]:
        themes.append(typeFormation.text)
    for ville in html_content.find_all('span', attrs={'class': 'ville'})[1:]:
        lieu.append(ville.text)
    for date in html_content.find_all('span', attrs={'class': 'date'})[1:]:
        dates.append(date.text)
    for a in html_content.find_all('a', attrs={'class': 'pure-button pure-button-primary'})[1:]:
        infos.append("https://cemea-formation.com/f/bafa" + a["href"])
        accueil.append("Non renseigné")
   
    toCsv = {"Date" : dates, "Themes" : themes, "Lieu" : lieu, "Accueil" : accueil, "infos" : infos}
    import pandas as pd
    print(toCsv)

    
    #pd.DataFrame.from_dict(toCsv).to_csv("SiteFnfr.csv", encoding="utf-8")
    browser.quit()      
    
CEMEA()