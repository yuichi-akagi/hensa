@extends('manage.layout')

@section('content')
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">データ一覧</h1>
    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4 border border-gray-300">ID</th>
          <th class="py-2 px-4 border border-gray-300">名前</th>
          <th class="py-2 px-4 border border-gray-300">操作</th>
        </tr>
      </thead>
@foreach ( $result as $rec )
      <tbody>
        <tr class="hover:bg-gray-100">
          <td class="py-2 px-4 border border-gray-300">{{ $rec->id }}</td>
          <td class="py-2 px-4 border border-gray-300">{{ $rec->name }}</td>
          <td class="py-2 px-4 border border-gray-300">
@if ( $rec->stat_count )
            <a href="{{ route('manage.hs.stat_index',['year' => $year,'hd_id' => $rec->id]) }}" class="text-blue-500 hover:underline">年別データ</a>
@endif
@if ( $rec->stat_dept_count )
            <a href="edit.html?id=1" class="text-blue-500 hover:underline">学科別データ</a>
@endif
          </td>
        </tr>
@endforeach
      </tbody>
    </table>
  </div>
@stop
