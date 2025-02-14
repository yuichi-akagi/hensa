sqlite3 ./database/database.sqlite   < create_tables.sql 
php artisan import:hs saitama/high.tsv
php artisan import:hs_stat_gr saitama/gr_2023.tsv 2023

php artisan import:hs_stat_gr saitama/gr_2022.tsv 2022
php artisan import:hs_stat_gr saitama/gr_2021.tsv 2021
php artisan import:hs_stat_gr saitama/gr_2020.tsv 2020

php artisan import:hs_stat_ad saitama/ad_2017_1.txt 2017
php artisan import:hs_stat_ad saitama/ad_2017.txt 2017 1

php artisan import:hs_stat_ad saitama/ad_2018_1.txt 2018
php artisan import:hs_stat_ad saitama/ad_2018.txt 2018 1

php artisan import:hs_stat_ad saitama/ad_2019_1.txt 2019
php artisan import:hs_stat_ad saitama/ad_2019.txt 2019 1

php artisan import:hs_stat_ad saitama/ad_2020_1.txt 2020
php artisan import:hs_stat_ad saitama/ad_2020.txt 2020 1

php artisan import:hs_stat_ad saitama/ad_2021_1.txt 2021
php artisan import:hs_stat_ad saitama/ad_2021.txt 2021 1

php artisan import:hs_stat_ad saitama/ad_2022_1.txt 2022
php artisan import:hs_stat_ad saitama/ad_2022.txt 2022 1

php artisan import:hs_stat_ad saitama/ad_2023_1.txt 2023
php artisan import:hs_stat_ad saitama/ad_2023.txt 2023 1

php artisan import:univ univs/univ_2025_1.tsv 1 2025 2025
php artisan import:univ univs/univ_2025_1_2.tsv 1 2025 2025
php artisan import:univ univs/univ_2025_2.tsv 1 2025 2025
php artisan import:univ univs/univ_2025_2_2.tsv 1 2025 2025

php artisan import:univ univs/univ_2025_1.tsv 1 2024 2025
php artisan import:univ univs/univ_2025_1_2.tsv 1 2024 2025
php artisan import:univ univs/univ_2025_2.tsv 1 2024 2025
php artisan import:univ univs/univ_2025_2_2.tsv 1 2024 2025

php artisan import:univ univs/univ_2025_1.tsv 1 2023 2025
php artisan import:univ univs/univ_2025_1_2.tsv 1 2023 2025
php artisan import:univ univs/univ_2025_2.tsv 1 2023 2025
php artisan import:univ univs/univ_2025_2_2.tsv 1 2023 2025

php artisan import:univ univs/univ_2025_1.tsv 1 2022 2025
php artisan import:univ univs/univ_2025_1_2.tsv 1 2022 2025
php artisan import:univ univs/univ_2025_2.tsv 1 2022 2025
php artisan import:univ univs/univ_2025_2_2.tsv 1 2022 2025

php artisan import:univ univs/univ_2025_1.tsv 1 2021 2025
php artisan import:univ univs/univ_2025_1_2.tsv 1 2021 2025
php artisan import:univ univs/univ_2025_2.tsv 1 2021 2025
php artisan import:univ univs/univ_2025_2_2.tsv 1 2021 2025

php artisan import:univ univs/univ_2025_1.tsv 1 2020 2025
php artisan import:univ univs/univ_2025_1_2.tsv 1 2020 2025
php artisan import:univ univs/univ_2025_2.tsv 1 2020 2025
php artisan import:univ univs/univ_2025_2_2.tsv 1 2020 2025

php artisan import:pass_result ./saitama/hs_1.txt 
php artisan import:pass_result saitama/hs_74.txt 

php artisan import:hs_stat_ss saitama/hs_ss_2025.tsv 2025 2025
php artisan import:hs_stat_ss saitama/hs_ss_2025.tsv 2024 2025
php artisan import:hs_stat_ss saitama/hs_ss_2025.tsv 2023 2025
php artisan import:hs_stat_ss saitama/hs_ss_2025.tsv 2022 2025
php artisan import:hs_stat_ss saitama/hs_ss_2025.tsv 2021 2025
php artisan import:hs_stat_ss saitama/hs_ss_2025.tsv 2020 2025

			
