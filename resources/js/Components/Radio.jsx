export default function Radio({
    name,
    label,
    options = [],
    selectedVal = "",
    handleChange,
}) {
    return (
        <>
            <span className="text-gray-700 dark:text-gray-400">{label}</span>
            <div className="mt-2">
                {options.map((opt) => {
                    return (
                        <label
                            key={opt.value}
                            className="inline-flex items-center text-gray-600 dark:text-gray-400"
                        >
                            <input
                                checked={selectedVal == opt.value}
                                type="radio"
                                className="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                name={name}
                                value={opt.value}
                                onChange={handleChange}
                            />
                            <span className="ml-2">{opt.label}</span>
                        </label>
                    );
                })}
            </div>
        </>
    );
}
