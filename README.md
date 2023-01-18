<!--
SPDX-FileCopyrightText: 2023 Davidson <twister@davidson.fr>
SPDX-License-Identifier: CC-BY-NC-SA-4.0
-->

# Tests Snippets

## About

The goal of this project is to collect some ETSdiff test whatever the programing language; from the simple coding rules to more complicated optimisation transfert.

**Warn:** this is a very beta stage and subject to a lot of changes

## Organisation

Acutaly only for ecocode rules

```
* (local copie repository)
|-- rules.md (description of rules code)
`-- $(language) (ie: php)
    |-- $(ruleid) (rule code ie: s74)
    |   |-- ets.yml (ETSdiff configuration file to run the test
    |   |-- docker-compose.yml (service to run the test)
	|	`-- app (directory to store tests)
    |       |-- compilant.tst (compilant test access ie: compilant.php)
    |       `-- non-compilant.tst (non-compilant test access ie: non-compilant.php)
    `-- (... another rule, etc.)
```

## Installing

We use docker & docker-compose so you need to install it

* Ubuntu: 
    * `sudo apt install docker-compose`
    * `sudo usermod -aG docker $USER`
    * `sudo apt install mysql-client` *if you want to access db from host*

We use [OpenDataBDD](http://git-twister.davidson-idf.fr/davidson/greenit/opendatabdd) project that provide bdd docker instances.

* You need to link this project at the root level of this one:
	* ln -s ../$(where-opendatabdd-cloned) opendatabdd

To run one test you need [ETSdiff](http://git-twister.davidson-idf.fr/davidson/greenit/etsdiff)

**IMPORTANT** befor you be able to run etsdiff you need to create bdd variants config file ie:

```
cd php/s72
../../create_ets_db_variant.sh
```
