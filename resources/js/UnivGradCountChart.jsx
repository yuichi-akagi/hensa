import React from 'react';
import ReactDOM from 'react-dom/client';
import {
  ComposedChart,
  LineChart,
  Line,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer
} from 'recharts';

const UnivGradCountChart = () => {
  const [data, setData] = React.useState([]);
  const [loading, setLoading] = React.useState(true);
  const [error, setError] = React.useState(null);

  // DOMからパラメータを取得する関数
  const getChartParams = () => {
    const chartUnivGrad = document.getElementById('chart-univ-grad-count');
    return {
      schoolId: chartUnivGrad?.dataset?.schoolId,
      type: chartUnivGrad?.dataset?.type
    };
  };

  // データを取得する関数
  const fetchData = async () => {
    try {
      setLoading(true);
      const params = getChartParams();
      
      // URLSearchParamsを使用してクエリパラメータを構築
      const queryParams = new URLSearchParams({
        hs_id: params.schoolId || '',
        dept_type: params.type || ''
      });

      // APIエンドポイントにパラメータを付加
      const response = await fetch(
        `/hensa/api/univ_grad_count.json?${queryParams.toString()}`
      );
      if (!response.ok) {
        throw new Error('データの取得に失敗しました');
      }
      const jsonData = await response.json();
      setData(jsonData);
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  React.useEffect(() => {
    fetchData();
  }, []);

  if (loading) {
    return <div className="text-center p-4">データを読み込み中...</div>;
  }

  if (error) {
    return <div className="text-center p-4 text-red-500">エラーが発生しました: {error}</div>;
  }

const maxValue = Math.max(...data.map(d => d.bar1));
console.log(maxValue)

  return (
  <div style={{ width: "100%", height: "300px", border: "1px solid red" }}>
    <ResponsiveContainer width="100%" height="100%">
          <ComposedChart
            data={data}
            margin={{
              top: 20,
              right: 30,
              left: 20,
              bottom: 10
            }}
          >
            <CartesianGrid strokeDasharray="3 3" />
            <XAxis 
              dataKey="year"
              tick={{ fill: '#666' }}
            />
            <YAxis 
domain={[0, maxValue * 1.25]}
scale="linear"
              yAxisId="left"
              orientation="left"
              tick={{ fill: '#666' }}
              label={{ value: '人数', angle: -90, position: 'insideLeft' }}
            />
            <YAxis 
              yAxisId="right"
              orientation="right"
              tick={{ fill: '#666' }}
              label={{ value: '%', angle: 90, position: 'insideRight' }}
            />
            <Tooltip 
              contentStyle={{
                backgroundColor: 'white',
                border: '1px solid #ccc',
                borderRadius: '4px'
              }}
            />
            <Legend />
            <Bar 
              yAxisId="left"
              dataKey="bar1" 
              name="卒業者数" 
              fill="#f97316"
              barSize={40}
              radius={[4, 4, 0, 0]}
            />
            <Bar 
              yAxisId="left"
              dataKey="bar2" 
              name="大学進学者数" 
              fill="#fb923c"
              barSize={40}
              radius={[4, 4, 0, 0]}
            />
            <Line
              yAxisId="right"
              type="monotone"
              dataKey="line"
              name="大学進学率"
              stroke="#3b82f6"
              strokeWidth={2}
              dot={{ r: 4 }}
              activeDot={{ r: 6 }}
            />
          </ComposedChart>
        </ResponsiveContainer>
    </div>
  );
};

// エクスポートを追加
export default UnivGradCountChart;
