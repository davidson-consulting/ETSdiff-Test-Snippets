#!/bin/sh

# SPDX-FileCopyrightText: 2023 Davidson <twister@davidson.fr>
# SPDX-License-Identifier: GPL-3.0-or-later

sed "s/(NB_MONTHS)/1/g" ../ets.toml > ets_1m.toml
sed "s/(NB_MONTHS)/2/g" ../ets.toml > ets_2m.toml
sed "s/(NB_MONTHS)/4/g" ../ets.toml > ets_4m.toml
sed "s/(NB_MONTHS)/8/g" ../ets.toml > ets_8m.toml
