import sys

def generate_hensa(input_file, output_file):
    with open(input_file, 'r', encoding='utf-8') as f_in, open(output_file, 'w', encoding='utf-8') as f_out:
        college = ""
        gakubu_hensa = 0
        gakubu_count = 0
        for line in f_in:
            tmp = line.strip().split("\t")
            if ( college == "" ) :
                college = tmp[0]
            if ( college != tmp[0] ) :
                if ( gakubu_count != 0 ) :
                    hensa = round(gakubu_hensa // gakubu_count,1)
                    f_out.write(college + "\t不明\t" + str(hensa) + "\n")
                college = tmp[0]
                gakubu_hensa = 0
                gakubu_count = 0
            if ( tmp[1] == "医学部" ) :
                continue
                f_out.write(college + "\t" + tmp[1] + "\t" + tmp[2] + "\n")
            elif ( tmp[1] in [ "歯学部","薬学部","法学部"] ) :
#                f_out.write(college + "\t" + tmp[1] + "\t" + tmp[2] + "\n")
                gakubu_hensa += float(tmp[2]);
                gakubu_count += 1
            else :
                gakubu_hensa += float(tmp[2]);
                gakubu_count += 1

        if ( gakubu_count != 0 ) :
            hensa = round(gakubu_hensa // gakubu_count,1)
            f_out.write(college + "\t不明\t" + str(hensa) + "\n")
    
if __name__ == "__main__":
    if len(sys.argv) != 3:
        sys.exit(1)

    input_file = sys.argv[1]
    output_file = sys.argv[2]
    generate_hensa(input_file, output_file)
    print(f"ファイル '{input_file}' を '{output_file}' に変換しました。")
