import React from 'react';
import ReactDOM from 'react-dom/client';
//import { PieChart, Pie, Cell, ResponsiveContainer, Tooltip, Legend } from 'recharts';
import UniversityChart from './UniversityChart';  // コンポーネントのファイル名に合わせて調整

import UnivGradCountChart from './UnivGradCountChart';  // コンポーネントのファイル名に合わせて調整
//const UniversityChart = lazy(() => import('./UniversityChart'));

const root = ReactDOM.createRoot(document.getElementById('chart-root'))
root.render(
  <React.StrictMode>
    <UniversityChart />
  </React.StrictMode>
);

const root2 = ReactDOM.createRoot(document.getElementById('chart-univ-grad-count'))
root2.render(
  <React.StrictMode>
    <UnivGradCountChart />
  </React.StrictMode>
);
