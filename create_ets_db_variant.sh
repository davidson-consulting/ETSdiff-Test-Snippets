#!/bin/sh

# SPDX-FileCopyrightText: 2023 Davidson <twister@davidson.fr>
# SPDX-License-Identifier: GPL-3.0-or-later

sed "s/(NB_MONTHS)/1/g" ets.yml > ets_1m.yml
sed "s/(NB_MONTHS)/2/g" ets.yml > ets_2m.yml
sed "s/(NB_MONTHS)/4/g" ets.yml > ets_4m.yml
sed "s/(NB_MONTHS)/8/g" ets.yml > ets_8m.yml
