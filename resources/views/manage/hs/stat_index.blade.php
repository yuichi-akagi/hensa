@extends('manage.layout')

@section('content')
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ $hs->name }} {{ $year }}年度</h1>

@foreach ( $stats as $rec )
    <h2 class="text-lg">{{ $rec->dept_type }}</h2>
    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4 border border-gray-300">ID</th>
          <th class="py-2 px-4 border border-gray-300">卒業年</th>
          <th class="py-2 px-4 border border-gray-300">卒業者数（大学進学者数）</th>
          <th class="py-2 px-4 border border-gray-300">大学偏差値（偏差値換算年）</th>
        </tr>
      </thead>
      <tbody>
        <tr class="hover:bg-gray-100">
          <td class="py-2 px-4 border border-gray-300">{{ $rec->id }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec->grad_year }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec->grad_count}}（{{ $rec->grad_university_count}} ）</td>
          <td class="py-2 px-4 border border-gray-300">{{ number_format($rec->grad_ss,2) }}（{{ $rec->grad_ss_year }}年）</td>
          </td>
        </tr>
      </tbody>
    </table>

    <table class="min-w-full bg-white border border-gray-300 mt-10">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4 border border-gray-300">入学年</th>
          <th class="py-2 px-4 border border-gray-300">入学者数（募集数）</th>
          <th class="py-2 px-4 border border-gray-300">高校偏差値（偏差値換算年）</th>
        </tr>
      </thead>
      <tbody>
        <tr class="hover:bg-gray-100">
          <td class="py-2 px-4 border border-gray-300">{{ $rec->adm_year }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec->adm_count}}（{{ $rec->recruit_count}} ）</td>
          <td class="py-2 px-4 border border-gray-300">{{ number_format($rec->adm_ss,2) }}（{{ $rec->adm_ss_year }}年）</td>
          </td>
        </tr>
      </tbody>
    </table>

@if ( $rec->grad_ss && $rec->adm_ss ) 
    <table class="min-w-full bg-white border border-gray-300 mt-10">
        <tr>
            <th class="bg-gray-200 py-2 px-4 border border-gray-300">進学偏差</th>
            <td class="py-2 px-4 border border-gray-300">{{ number_format(100 + $rec->grad_ss - $rec->adm_ss,2) }}</td>
        </tr>
    </table>

@endif

@if ( count($rec->results) )
    <table class="min-w-full bg-white border border-gray-300 mt-10">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4 border border-gray-300">大学名</th>
          <th class="py-2 px-4 border border-gray-300">学部</th>
          <th class="py-2 px-4 border border-gray-300">合格・進学</th>
          <th class="py-2 px-4 border border-gray-300">人数</th>
          <th class="py-2 px-4 border border-gray-300">偏差値</th>
        </tr>
      </thead>
    @foreach ( $rec->results as $rec2 )
      <tbody>
        <tr class="hover:bg-gray-100">
          <td class="py-2 px-4 border border-gray-300">{{ $rec2->univ->name }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec2->faculty_name }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec2->result }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec2->grad_count }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec2->grad_ss }}（{{ $rec2->grad_ss_year }}）</td>
        </tr>
      </tbody>
@endforeach
    </table>
@endif
@endforeach

@if ( count($other_results) )
<h2>その他</h2>
    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4 border border-gray-300">大学名</th>
          <th class="py-2 px-4 border border-gray-300">学部</th>
          <th class="py-2 px-4 border border-gray-300">合格・進学</th>
          <th class="py-2 px-4 border border-gray-300">人数</th>
          <th class="py-2 px-4 border border-gray-300">偏差値</th>
        </tr>
      </thead>
    @foreach ( $other_results as $rec2 )
      <tbody>
        <tr class="hover:bg-gray-100">
          <td class="py-2 px-4 border border-gray-300">{{ $rec2->univ->name }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec2->faculty_name }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec2->result }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec2->grad_count }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec2->grad_ss }}（{{ $rec2->grad_ss_year }}）</td>
        </tr>
      </tbody>
@endforeach
    </table>
@endif

  </div>
@stop
