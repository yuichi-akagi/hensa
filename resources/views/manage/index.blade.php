@extends('manage.layout')

@section('content')
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">卒業（予定）年度</h1>
    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4 border border-gray-300">年度</th>
          <th class="py-2 px-4 border border-gray-300">高校</th>
          <th class="py-2 px-4 border border-gray-300">大学</th>
        </tr>
      </thead>
      <tbody>
@foreach ( $year_list as $rec )
        <tr class="hover:bg-gray-100">
          <td class="py-2 px-4 border border-gray-300">{{ $rec }}</td>
          <td class="py-2 px-4 border border-gray-300"><a href="{{ route('manage.hs.top',['year' => $rec]) }}">高校情報</a></td>
          <td class="py-2 px-4 border border-gray-300">大学情報</td>
        </tr>
@endforeach
      </tbody>
    </table>
  </div>
@stop
