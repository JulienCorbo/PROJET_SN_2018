# -*- coding: utf-8 -*-
#!/usr/bin/python

# Import datetime and stfrtime module.
import datetime
from time import strftime
from random import randint


# Import the ADS1x15 module.
import Adafruit_ADS1x15

# Import mysqldb module.
import MySQLdb as mdb

# Create an ADS1115 ADC (16-bit) instance.
adc = Adafruit_ADS1x15.ADS1115()

# GAIN :
#  - 2/3 = +/-6.144V
#  -   1 = +/-4.096V
#  -   2 = +/-2.048V
#  -   4 = +/-1.024V
#  -   8 = +/-0.512V
#  -  16 = +/-0.256V
GAIN = 2/3

# Connexion BDD
conn = mdb.connect(host = "localhost",user = "root",passwd = "raspberry",db ="pool3k")

# Read all the ADC channel values in a list.
values = [0]*3
v = [0]*3
voltvalues = [0]*3
for i in range(3):
    # Read the specified ADC channel using the previously set gain value.
    v[i] = adc.read_adc(i, gain=GAIN)
    values[i] = float(v[i])
    # Translate CAN values into voltage values
  
# Print the ADC values.
for y in range(3):
    print('Capteur %s :  %s' %(y,values[y]))

# random de 24 a 27
temp = randint(24,27)
# Produit en croix pour le ph ( si on obtient 4480 ca vaut 14 ph )
ph = ((values[1]*14)/4480)
# Calcul pour le chlore (E=produit en croix) (cl=calcul compliqué sortit de la doc)
E = ((values[2]*6.144)/32767)*1000
cl = 10**((E-(715+50*(7-ph)))/(300+50*(7-ph)))

# Insert values in BDD
try:
    curseur = conn.cursor()
    curseur.execute("""INSERT INTO statements
    (`id`, `sample_date`,`sample_time`,`temp`,`ph`,`cl`)
    VALUES (NULL,%s,%s,%.4s,%.4s,%.4s)""",(strftime("%Y/%m/%d"),strftime("%H:%M:%S"),temp,ph,cl))
    print('Valeurs entrées en BDD')
    conn.commit()
finally:
    if conn:
        conn.close()


    
