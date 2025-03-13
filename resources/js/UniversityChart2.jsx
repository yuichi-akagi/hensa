import React from 'react';
import ReactDOM from 'react-dom/client';
import { PieChart, Pie, Cell, ResponsiveContainer, Tooltip, Legend } from 'recharts';

const UniversityChart2 = () => {
  const [data, setData] = React.useState([]);
  const [loading, setLoading] = React.useState(true);
  const [error, setError] = React.useState(null);

  // DOMからパラメータを取得する関数
  const getChartParams = () => {
    const chartRoot = document.getElementById('chart-root2');
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
        `/hensa/api/univ2.json?${queryParams.toString()}`
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
        { name: '慶應義塾大学（法学部）', value: 74, percentage: 31.6 },
        { name: '経済学部', value: 80, percentage: 34.2 },
        { name: '商学部', value: 18, percentage: 7.7 }
      ]);
    } finally {
      setLoading(false);
    }
  };

  const generateColors = (count) => {
    const baseColors = [
      '#f97316', '#fb923c', '#fdba74', 
      '#ea580c', '#f43f5e', '#ec4899', '#d946ef', '#a855f7', '#8b5cf6',
      '#6366f1', '#3b82f6', '#0ea5e9', '#06b6d4', '#14b8a6', '#10b981'
    ];

    if (count <= baseColors.length) {
      return baseColors.slice(0, count);
    }

    // 基本色が足りない場合は色を補間して生成
    const colors = [...baseColors];
    for (let i = baseColors.length; i < count; i++) {
      const hue = (i * 137.508) % 360; // 黄金角を使用して色相を分散
      const saturation = 70;
      const lightness = 60;
      colors.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
    }
    return colors;
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

  const COLORS = generateColors(data.length);

  return (
  <div style={{ width: "100%", height: "500px" }}>
    <ResponsiveContainer>
      <PieChart width={0}>
        <Pie
          data={data}
          cx="50%"
          cy="50%"
          innerRadius={60}
          outerRadius={80}
          fill="#8884d8"
          paddingAngle={5}
          dataKey="value"
          label
        >
          {data.map((entry, index) => (
            <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
          ))}
        </Pie>
        <Tooltip 
          formatter={(value, name) => [
            `${value}名 (${data.find(item => item.name === name)?.percentage}%)`,
            name
          ]}
        />
        <Legend
          layout="vertical"
          align="center"
          verticalAlign="bottom"
        />
      </PieChart>
    </ResponsiveContainer>
</div>
  );
};

// エクスポートを追加
export default UniversityChart2;
