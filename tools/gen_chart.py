import yaml
from yaml.loader import SafeLoader

import matplotlib.pyplot as plt
import numpy as np
import pandas as pd

def tests_to_precent(tests):
    pe = 0
    pt = 0
    ps = 0
    for test in tests:
        if pe < test[1]:
            pe = test[1]
        if pt < test[2]:
            pt = test[2]
        if ps < test[3]:
            ps = test[3]
    for test in tests:
        test[1] = test[1] * 100 / pe
        test[2] = test[2] * 100 / pt
        test[3] = test[3] * 100 / ps

def agen_precent_chart(input, output='percent.png', show_only=False):
    if output == None:
        output = 'percent.png'
    with open(input) as f:
        data = yaml.load(f, Loader=SafeLoader)
        df = pd.io.json.json_normalize(data, 'total').transpose()


def gen_precent_chart(input, output='percent.png', show_only=False):
    if output == None:
        output = 'percent.png'
    with open(input) as f:
        data = yaml.load(f, Loader=SafeLoader)
        tests = []
        for ets_report in data['total']:
            tests.append([
                ets_report['name'],
                ets_report['energy'],
                ets_report['transfer'],
                ets_report['storage']
                ])
        tests_to_precent(tests)
    
        data = [['Energy'], ['Transfer'], ['Storage']]
        columns = ['Criteria']
        for test in tests:
            columns.append(test[0])
            data[0].append(test[1])
            data[1].append(test[2])
            data[2].append(test[3])
        df = pd.DataFrame(data, columns=columns)
    
        ax = df.plot(
            fontsize='small',
            figsize=(4,2),
            width=0.8,
            x=0,
            xlabel='',
            rot=0,
            kind='bar',
            stacked=False,
            title='ETSdiff percent comparison'
            )
        for container in ax.containers:
            ax.bar_label(container, padding=0, fontsize='xx-small', label_type='center', fmt='%.1f')
        ax.legend(loc='center left', bbox_to_anchor=(1.0, 0.5), fontsize='x-small')
        plt.yticks(np.arange(0, 120, 25))
        plt.tight_layout()
        if show_only == True:
            plt.show()
        else:
            plt.savefig(output)
    
if __name__ == '__main__':
    import argparse

    argParser = argparse.ArgumentParser(description='Generate graphics from ETSdiff output',)
    argParser.add_argument('input', help='ETSdiff output file')
    argParser.add_argument('-o', '--output', help='png output file')
    argParser.add_argument('-s', '--show', help='show only', default=False, action=argparse.BooleanOptionalAction)

    args = argParser.parse_args()
    gen_precent_chart(args.input, args.output, args.show)
