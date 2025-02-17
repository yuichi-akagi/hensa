@extends('layout')

@section('title','【' . $hs_stat->grad_year . '年度】' . $hs_stat->hs->name . 'の進学偏差')
@section('description',$hs_stat->hs->name . 'の' . $hs_stat->grad_year . '年度進学実績と進学偏差値を分析。卒業生の大学進学データや進学指導の効果を詳しく解説。進学偏差' . number_format(100 + $hs_stat->grad_ss - $hs_stat->adm_ss,2) .'の詳細な分析データを提供。')
@section('keywords',$hs_stat->hs->name . ', 進学偏差, 大学進学実績, 高校偏差値, 進学指導')
@section('stylesheets')
    <style>
        .chart-container {
            width: 400px;
            margin: 20px auto;
            position: relative;
        }
        .legend {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 20px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }
        .percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.2em;
            font-weight: bold;
        }
    </style>
@stop

@section('content')
    <div class="max-w-3xl mx-auto p-6">
        <!-- 高校情報テーブル -->
        <div class="bg-white shadow-lg rounded-2xl p-6 mb-6 border border-orange-300">
            <h1 class="text-2xl font-bold text-orange-800 mb-4">{{ $hs_stat->hs->name }}</h1>
            <table class="w-full border-collapse border border-orange-300 rounded-xl"  aria-label="{{ $hs_stat->hs->name }}の基本情報">
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">所在地</th>
                    <td class="border border-orange-300 bg-white p-2">{{ $hs_stat->hs->address }}</td>
                </tr>
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">学科</th>
                    <td class="border border-orange-300 bg-white p-2">{{ $hs_stat->dept_type }}</td>
                </tr>
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">区分</th>
                    <td class="border border-orange-300 bg-white p-2">{{ $hs_stat->hs->kinds}}・{{ $hs_stat->hs->gender }}</td>
                </tr>
            </table>
        </div>

        <!-- 進学偏差 -->
        <div class="mb-6">
            <table class="w-full text-3xl md:text-5xl text-left text-center text-orange-800 border-collapse rounded-2xl"  aria-label="{{ $hs_stat->hs->name }}の進学偏差地">
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">進学偏差</th>
                </tr>
                <tr>
                    <td class="border border-orange-300 bg-white p-2">{{ number_format(100 + $hs_stat->grad_ss - $hs_stat->adm_ss,2) }}</td>
                </tr>
            </table>
        </div>
<div class="mb-6"><p class="italic bg-yellow-100 text-amber-800 p-4 rounded mb-4">「<span class="text-xl md:text-2xl text-bold">進学偏差</span>」とは、大学の偏差値から高校の偏差値を引くことにより、その高校における進学指導の効果を数値化したものです。<br>式としては『<span class="text-xl md:text-2xl text-bold">100＋大学偏差値－高校偏差値</span>』で表します。<br>この指標はあくまで統計的な参考値であり、個々の生徒の努力や様々な要因により、<br>実際の進学結果は大きく異なる可能性があります。<br><br>また、この数値の算出には以下の制約があることにご留意ください：<br>　・大学の偏差値は学部により異なりますが、公表データの制限により平均値を使用しています<br>　・進学先が不明な場合は一定の仮定のもとで計算しています<br>　・単年度のデータに基づいているため、年度による変動があります</p></div>

            
        <!-- 高校情報テーブル -->
        <div class="bg-white shadow-lg rounded-2xl p-6 mb-6 border border-orange-300">
            <table class="w-full border-collapse border border-orange-300 rounded-xl mt-4" aria-label="{{ $hs_stat->hs->name }}の進学情報">
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">合格大学偏差値平均</th>
                    <td class="border border-orange-300 bg-white p-2 text-2xl">{{ number_format($hs_stat->grad_ss,2) }}</td>
                </tr>
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">合格実績年度</th>
                    <td class="border border-orange-300 bg-white p-2">{{ $hs_stat->grad_year }}年</td>
                </tr>
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">大学偏差基準年度</th>
                    <td class="border border-orange-300 bg-white p-2">{{ $hs_stat->grad_ss_year }}年</td>
                </tr>
            </table>

        
            <table class="w-full border-collapse border border-orange-300 rounded-xl mt-4" aria-label="{{ $hs_stat->hs->name }}の入学時偏差値情報">
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">高校入学偏差値</th>
                    <td class="border border-orange-300 bg-white p-2 text-2xl">{{ number_format($hs_stat->adm_ss,2) }}</td>
                </tr>
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">高校入学年度</th>
                    <td class="border border-orange-300 bg-white p-2">{{ $hs_stat->adm_year }}年</td>
                </tr>
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">高校偏差基準年度</th>
                    <td class="border border-orange-300 bg-white p-2">{{ $hs_stat->adm_ss_year }}年</td>
                </tr>
            </table>
        </div>

        <div class="university-list bg-white shadow-md rounded-xl p-4 mb-6 border border-orange-200">
            <h2 class="text-xl font-bold text-orange-700">大学進学率</h2>
            <table class="w-full border-collapse border border-orange-300 rounded-xl mt-4" aria-label="{{ $hs_stat->hs->name }}の大学進学率情報">
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">大学進学率</th>
                    <td class="border border-orange-300 bg-white p-2 text-2xl">
@if ( $hs_stat->grad_count )
{{ number_format($hs_stat->grad_university_count/ $hs_stat->grad_count * 100,2) }}%
@endif
</td>
                </tr>
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">大学進学者数</th>
                    <td class="border border-orange-300 bg-white p-2">{{ strcat($hs_stat->grad_university_count,'人')  }}</td>
                </tr>
                <tr>
                    <th class="border border-orange-300 bg-orange-800 text-white p-2">卒業者数</th>
                    <td class="border border-orange-300 bg-white p-2">{{ strcat($hs_stat->grad_count,'人')  }}</td>
                </tr>
            </table>
            <div class="mt-4">
<div id="chart-univ-grad-count" data-school-id="{{ $hs_stat->hs->id }}" data-type="{{ $hs_stat->dept_type }}"></div>
            </div>
        </div>
        <!-- 大学進学情報リスト -->
        <div class="university-list bg-white shadow-md rounded-xl p-4 mb-6 border border-orange-200">
            <h2 class="text-xl font-bold text-orange-700">進学先大学</h2>
<div id="chart-root" data-school-id="{{ $hs_stat->hs->id }}" data-year="{{ $hs_stat->grad_year }}" data-type="{{ $hs_stat->dept_type }}"></div>
@foreach ( $pass_results as $rec )
            <div class="university-item flex justify-between items-center py-2 border-b border-gray-300">
                <span class="university-name">{{ $rec->univ->name }}{{ strcat('（',str_replace('不明','',$rec->faculty_name),'）') }} {{ $rec->grad_count }}名</span>
                <span class="university-score font-bold text-gray-700">偏差値: {{ $rec->grad_ss }}</span>
            </div>
@endforeach


        </div>

<?php /*
        <!-- 近い高校のリスト -->
        <div class="related-schools bg-white shadow-md rounded-xl p-4 border border-orange-200">
            <h2 class="text-xl font-bold text-orange-700">進学偏差が近い高校</h2>
            <div class="related-school-item py-2 border-b border-gray-200">
                <a href="#" class="related-school-link text-blue-500 hover:underline">△△高校（進学偏差: 94）</a>
            </div>
            <div class="related-school-item py-2">
                <a href="#" class="related-school-link text-blue-500 hover:underline">□□高校（進学偏差: 96）</a>
            </div>
        </div>
*/ ?>
    </div>
@stop
