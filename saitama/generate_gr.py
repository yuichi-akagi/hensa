import sys

def convert_to_tsv(input_file, output_file):
    with open(input_file, 'r', encoding='utf-8') as f_in, open(output_file, 'w', encoding='utf-8') as f_out:
        school = "";
        type = "";
        for line in f_in:
            tmp = line.split("\t");
            if ( len(tmp) < 4 ) :
                continue

            if ( tmp[0] ) :
                type = tmp[0].strip();

            if ( tmp[1] ) :
                school = tmp[1].strip();

            if ( tmp[2].strip() == '現役' ) :
                f_out.write(school + "\t" + type + "\t" + tmp[3] + "\t" + tmp[30] + "\n")

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("使い方: python generate_gu.py <入力ファイル> <出力ファイル>", file=sys.stderr)
        sys.exit(1)

    input_file = sys.argv[1]
    output_file = sys.argv[2]
    convert_to_tsv(input_file, output_file)
    print(f"ファイル '{input_file}' を '{output_file}' に変換しました。")
