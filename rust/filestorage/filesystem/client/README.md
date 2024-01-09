Gatling plugin for SBT 
=======================

There are 4 scenarios to launch : 
- FileSystemIsUp
- FileSystemUpload
- FileSystemDownload
- FileSystemDelete

A scenario is launch using the command sbt, for example for the scenario FileSystemIsUp : 

``` shell
$ sbt "gatling / testOnly filesystem.FileSystemIsUp"
```

Upload depends on the scenario IsUp.
The scenario IsUp, clear or generate the csv file that will be filled by the scenario Upload.
This file contains the UUID of the files the server has returned during the uploading phase.

Download and Delete depends on the scenario Upload.
They need a correct ids.csv file to work properly.
