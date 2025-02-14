import sys

def convert_to_tsv(input_file, output_file):
    """
    ファイルを読み込み、TSV形式で出力する。

    Args:
        input_file (str): 入力ファイル名。
        output_file (str): 出力ファイル名。
    """

    try:
        with open(input_file, 'r', encoding='utf-8') as f_in, open(output_file, 'w', encoding='utf-8') as f_out:
            college="";
            gakubu="";
            for line in f_in:
                line = line.strip().replace(" ","")
                if ( line ) :
                    if ( college == "" ):
                        college = line
                    elif ( line[0:3] == '偏差値' ):
                        hensa = line[3:]
                        if ( hensa.find("BF") != -1 ) : #BFがある偏差値は除外
                            continue
                        if ( hensa.find("-") == 0 ) :   #値のないものも除外
                            continue
                        if ( hensa.find("-") != -1 ) :
                            tmp = hensa.split("-")
                            hensa = (float(tmp[0]) + float(tmp[1]) )/ 2;
                        f_out.write(college + "\t" + gakubu + "\t" + str(hensa) + "\n")
                    else :
                        gakubu = line
                else :
                    college = ""
                    gakubu = ""
    except FileNotFoundError:
        print(f"エラー: ファイル '{input_file}' が見つかりません。", file=sys.stderr)
    except Exception as e:
        print(f"エラー: 予期せぬエラーが発生しました: {e}", file=sys.stderr)

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("使い方: python script.py <入力ファイル> <出力ファイル>", file=sys.stderr)
        sys.exit(1)

    input_file = sys.argv[1]
    output_file = sys.argv[2]
    convert_to_tsv(input_file, output_file)
    print(f"ファイル '{input_file}' を '{output_file}' に変換しました。")
