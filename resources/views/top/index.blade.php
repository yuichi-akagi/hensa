@extends('layout')

@section('title','進学偏差 高校一覧')
@section('description','')
@section('keywords','進学偏差, 大学進学実績, 高校偏差値, 進学指導')
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
<div class="mb-6"><p class="italic bg-yellow-100 text-amber-800 p-4 rounded mb-4">「<span class="text-xl md:text-2xl text-bold">進学偏差</span>」とは、大学の偏差値から高校の偏差値を引くことにより、その高校における進学指導の効果を数値化したものです。<br>式としては『<span class="text-xl md:text-2xl text-bold">100＋大学偏差値－高校偏差値</span>』で表します。<br>この指標はあくまで統計的な参考値であり、個々の生徒の努力や様々な要因により、<br>実際の進学結果は大きく異なる可能性があります。<br><br>また、この数値の算出には以下の制約があることにご留意ください：<br>　・大学の偏差値は学部により異なりますが、公表データの制限により平均値を使用しています<br>　・進学先が不明な場合は一定の仮定のもとで計算しています<br>　・単年度のデータに基づいているため、年度による変動があります</p></div>
@foreach ( $pref_list as $key => $name )
        <!-- 都道府県別高校リスト -->
        <div class="bg-white shadow-lg rounded-2xl p-6 border border-orange-300">
            <h2 class="text-2xl font-bold text-orange-800 mb-4">{{ $name }}</h2>
            <ul class="list-disc list-inside text-lg">
@foreach ( $hs_list[$key] as $rec )
                <li><a href="{{ route('hs',['prefRoma' => $key,'hs_id' => $rec->id]) }}" class="text-blue-500 hover:underline">{{ $rec->name }}</a></li>
@endforeach
            </ul>
        </div>
@endforeach
@stop
