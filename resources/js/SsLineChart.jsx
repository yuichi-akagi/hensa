import React from 'react';
import ReactDOM from 'react-dom/client';
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer, Legend } from 'recharts';

const SsLineChart = () => {
  const [data, setData] = React.useState([]);
  const [loading, setLoading] = React.useState(true);
  const [error, setError] = React.useState(null);

  // DOMからパラメータを取得する関数
  const getChartParams = () => {
    const chartRoot = document.getElementById('ss-chart-root');
    return {
      schoolId: chartRoot?.dataset?.schoolId,
      year: chartRoot?.dataset?.year,
      type: chartRoot?.dataset?.type
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
        year: params.year || '',
        dept_type: params.type || ''
      });

      // APIエンドポイントにパラメータを付加
      const response = await fetch(
        `/hensa/api/ss_line.json?${queryParams.toString()}`
      );
      if (!response.ok) {
        throw new Error('データの取得に失敗しました');
      }
      const jsonData = await response.json();
      setData(jsonData);
    } catch (err) {
      setError(err.message);
//      console.error('Error:', err);
      // エラー時のダミーデータ
      setData([
  { x: 40, y1: 30, y2: 25 },
  { x: 41, y1: 45, y2: 35 },
  { x: 42, y1: 50, y2: 40 },
  { x: 43, y1: 70, y2: 55 },
  { x: 44, y1: 60, y2: 50 },
  { x: 45, y1: 80, y2: 65 },
  { x: 46, y1: 90, y2: 75 },
      ]);
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

  return (
  <div style={{ width: "100%", height: "500px" }}>
      <ResponsiveContainer width="100%" height="100%">
        <LineChart data={data} margin={{ top: 20, right: 30, left: 20, bottom: 10 }}>
          <CartesianGrid strokeDasharray="3 3" />
          <XAxis dataKey="x" type="number" domain={[40,75]} />
          <YAxis type="number" 
              label={{ value: '人数', angle: -90, position: 'insideLeft' }}
/>
          <Tooltip />
          <Legend />
          <Line type="monotone" dataKey="y1" name="合格偏差値" stroke="#ff7300" strokeWidth={3} dot={{ r: 5 }} />
          <Line type="monotone" dataKey="y2" name="進学偏差値" stroke="#0088ff" strokeWidth={3} dot={{ r: 5 }} />
        </LineChart>
      </ResponsiveContainer>
    </div>
  );
};

// エクスポートを追加
export default SsLineChart;
