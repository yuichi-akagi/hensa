import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom/client';  // ここを変更
import { PieChart, Pie, Cell, ResponsiveContainer, Tooltip, Legend } from 'recharts';

// React component for the chart
const UniversityChart = () => {
  const [data, setData] = React.useState([]);
  const [loading, setLoading] = React.useState(true);
  const [error, setError] = React.useState(null);

  // カラーパレットを生成する関数
  const generateColors = (count) => {
    const baseColors = [
      '#f97316', '#fb923c', '#fdba74', '#fed7aa', '#ffedd5', '#fff7ed',
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

  // データを取得する関数
  const fetchData = async () => {
    try {
      setLoading(true);
      // APIのエンドポイントを指定
      const response = await fetch('https://api.example.com/university-data');
      if (!response.ok) {
        throw new Error('データの取得に失敗しました');
      }
      const jsonData = await response.json();
      setData(jsonData);
    } catch (err) {
      setError(err.message);
      // エラー時にダミーデータを使用
      setData([
        { name: '法学部', value: 74, percentage: 31.6 },
        { name: '経済学部', value: 80, percentage: 34.2 },
        { name: '商学部', value: 18, percentage: 7.7 },
        { name: '文学部', value: 10, percentage: 4.3 },
        { name: '理工学部', value: 40, percentage: 17.1 },
        { name: 'その他学部', value: 12, percentage: 5.1 }
      ]);
    } finally {
      setLoading(false);
    }
  };

  // コンポーネントマウント時にデータを取得
  React.useEffect(() => {
    fetchData();
  }, []);

  if (loading) {
    return React.createElement('div', { className: 'text-center p-4' }, 'Loading...');
  }

  const COLORS = generateColors(data.length);

  return React.createElement(Recharts.PieChart, { width: 400, height: 400 },
    React.createElement(Recharts.Pie, {
      data: data,
      cx: "50%",
      cy: "50%",
      innerRadius: 60,
      outerRadius: 80,
      fill: "#8884d8",
      paddingAngle: 5,
      dataKey: "value"
    },
      data.map((entry, index) =>
        React.createElement(Recharts.Cell, {
          key: `cell-${index}`,
          fill: COLORS[index % COLORS.length]
        })
      )
    ),
    React.createElement(Recharts.Tooltip),
    React.createElement(Recharts.Legend, {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle'
    })
  );
};

// Mount the React component
const root = ReactDOM.createRoot(document.getElementById('chart-root'));
root.render(React.createElement(UniversityChart));
