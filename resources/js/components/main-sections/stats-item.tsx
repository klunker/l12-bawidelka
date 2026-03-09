export const StatsItem = ({
    label,
    value,
}: {
    label: string;
    value: string;
}) => (
    <div className="stat-item">
        <div className="stat-number">{value}</div>
        <div className="stat-label">{label}</div>
    </div>
);

export default StatsItem;
