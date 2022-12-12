export const TextInput = ({ onChange }) => {
    return (
        <div className="relative text-gray-500 focus-within:text-purple-600">
            <input
                className="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                placeholder="Type to filter"
                onChange={onChange}
            />
        </div>
    );
};
