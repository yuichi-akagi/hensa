import sys

def convert_to_tsv(input_file, output_file):
    with open(input_file, 'r', encoding='utf-8') as f_in, open(output_file, 'w', encoding='utf-8') as f_out:
        gakka = "";
        hensa = 0;
        gakka2 = "普通科";
        for line in f_in:
            line = line.strip()
            if ( line == "" ):
                continue
            if ( line.isnumeric() ) : #数字であるか判定
                gakka = ""
                hensa = 0
                continue
            if ( gakka == "" ):
                tmp = line.split(" ")
                gakka = tmp[0].strip()
            elif ( line[0:3] == '偏差値' ):
                hensa = line[3:].replace(" ","")
            else:
                gakka = gakka.replace(line,"")
                gakka2 = '普通科'
                if ( gakka == '普通科' ) :
                    gakka = ''
                elif ( gakka == '理数科' ) :
                    gakka2 = '理数科'
                    gakka = ''

                if ( gakka.find('理数科') != -1 ):
                    gakka2 = '理数科'
                f_out.write(line + "\t" + gakka2 + "\t" + gakka + "\t" + str(hensa) + "\n")

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("使い方: python script.py <入力ファイル> <出力ファイル>", file=sys.stderr)
        sys.exit(1)

    input_file = sys.argv[1]
    output_file = sys.argv[2]
    convert_to_tsv(input_file, output_file)
    print(f"ファイル '{input_file}' を '{output_file}' に変換しました。")
