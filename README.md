## TYPO3 12.1

### [Thema]
Masterarbeit Projekt: Konzeption und Entwicklung einer Video-Lernplattform

### [Abstract]
Im Rahmen dieser Masterarbeit wird eine Video-Lernplattform für Studenten erstellt. Das Ziel dieser Arbeit ist die Spezifikation der Plattform, das Entwickeln einer TYPO3-Extension und das Umsetzen in TYPO3.

### [Hochschule]
Hochschule Konstanz\
Technik, Wirtschaft und Gestaltung\
Brauneggerstr. 55\
78462 Konstanz

### [Betreuer]
Betreuer: Prof. Dr. Christian Johner\
Prof. Dr. Oliver Eck

## Set Up TYPO3

### 1
Create a folder named "Data". This folder will contain all data records of the videoportal.\
Inside the folder you must create three website user groups: public, partial and full.\
Now you can create website users and add them to the groups.

A video is associated with a category, a level and a targetgroup.\
This records must be created inside the "Data" folder (s. screenshot)

![alt text](https://github.com/juro-ub/typo3_video/raw/main/ReadmeImages/Backend/Records.png)

### 2
Now you must create a login page with the fe_login plugin.\
You must set the correct storage folder in the plugin settings.\
![alt text](https://github.com/juro-ub/typo3_video/raw/main/ReadmeImages/Backend/Login.png)

### 3
Create another page named "Video".\
Include the "Categroy Plugin" and the "Video Plugin".\
Configure the following settings of the plugins.\
  "Category Plugin": settings.feloginPid\
  "Video Plugin": settings.publicGroupUid, settings.partialGroupUid, settings.fullGroupUid\
After you have created the "Video" page, you must set the redirect after a successfull login in the fe_login plugin\
![alt text](https://github.com/juro-ub/typo3_video/raw/main/ReadmeImages/Backend/Video.png)
