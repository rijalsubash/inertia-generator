import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-react";
import { useEffect } from "react";
import { TextInput } from "../TextInput";

export const TablePaginationActions = ({
    previousPageUrl,
    nextPageUrl,
    currentPage,
    lastPage,
    from,
    to,
    total,
    handlePaninateByPageNumber,
    handlePageChange,
}) => {
    const paginationNumbers = (() => {
        let previousPages = [];
        let nextPages = [];
        let i = currentPage - 1;
        for (previousPages.length; previousPages.length < 3; i--) {
            if (i < 1) {
                break;
            }
            previousPages.push(i);
        }
        let next = currentPage + 1;
        for (nextPages.length; nextPages.length < 3; next++) {
            if (next > lastPage) {
                break;
            }
            nextPages.push(next);
        }
        return [
            previousPages.sort((a, b) => a - b),
            nextPages.sort((a, b) => a - b),
        ];
    })();

    return (
        <div className="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <span className="flex items-center col-span-3">
                Showing {from}-{to} of {total}
            </span>
            <span className="col-span-2"></span>
            <span className="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                    <ul className="inline-flex items-center">
                        {previousPageUrl && (
                            <li>
                                <button
                                    onClick={(e) =>
                                        handlePageChange(previousPageUrl)
                                    }
                                    className="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                                    aria-label="Previous"
                                >
                                    <svg
                                        className="w-4 h-4 fill-current"
                                        aria-hidden="true"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clipRule="evenodd"
                                            fillRule="evenodd"
                                        ></path>
                                    </svg>
                                </button>
                            </li>
                        )}
                        {paginationNumbers[0].map((num) => {
                            return (
                                <li key={num}>
                                    <button
                                        onClick={(e) =>
                                            handlePaninateByPageNumber(num)
                                        }
                                        className="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                                    >
                                        {num}
                                    </button>
                                </li>
                            );
                        })}

                        <li>
                            <button className="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">
                                {currentPage}
                            </button>
                        </li>
                        {paginationNumbers[1].map((num) => {
                            return (
                                <li key={num}>
                                    <button
                                        onClick={() =>
                                            handlePaninateByPageNumber(num)
                                        }
                                        className="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                                    >
                                        {num}
                                    </button>
                                </li>
                            );
                        })}
                        {nextPageUrl && (
                            <li>
                                <button
                                    onClick={(e) =>
                                        handlePageChange(nextPageUrl)
                                    }
                                    className="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                                    aria-label="Next"
                                >
                                    <svg
                                        className="w-4 h-4 fill-current"
                                        aria-hidden="true"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clipRule="evenodd"
                                            fillRule="evenodd"
                                        ></path>
                                    </svg>
                                </button>
                            </li>
                        )}
                    </ul>
                </nav>
            </span>
        </div>
    );
};
let timeOut = null;
const Datatable = ({
    columns,
    data,
    actionComponent,
    rowKey = "id",
    rowKeyFunc = null,
    children,
}) => {
    const { data: filterData, setData: setFilterData } = useForm({
        keyword: "",
    });
    const handleFilter = (e) => {
        let reqUrl = `${data.path}?perPage=${data.per_page}&keyword=${e.target.value}`;
        clearTimeout(timeOut);
        timeOut = setTimeout(() => {
            Inertia.get(
                reqUrl,
                {},
                { preserveState: true, preserveScroll: true }
            );
            setFilterData("keyword", e.target.value);
        }, 1000);
    };

    const handlePageChange = (url) => {
        Inertia.get(
            url + "&keyword=" + filterData.keyword,
            {},
            { preserveScroll: true, preserveState: true }
        );
    };

    const handlePaninateByPageNumber = (pageno) => {
        Inertia.get(
            data.first_page_url.replace("1", pageno) +
                "&keyword=" +
                filterData.keyword,
            {},
            {
                preserveScroll: true,
                preserveState: true,
            }
        );
    };

    const getCellContent = (key, col, row) => {
        const computedValue = col.computed ? col.computed(row) : row[col.field];

        if (col.renderFunc) {
            return col.renderFunc(row, computedValue);
        } else if (col.component) {
            return (
                <col.component
                    row={row}
                    computedValue={computedValue}
                ></col.component>
            );
        }

        return computedValue;
    };

    let Action = actionComponent;
    return (
        <>
            <div className="col-auto">
                <div className="grid grid-cols-6 gap-4 ">
                    <div className="col-span-12 md:col-end-7 md:col-span-2 ">
                        <TextInput onChange={handleFilter} />
                    </div>
                </div>
            </div>
            <table className="w-full whitespace-no-wrap">
                <thead>
                    <tr className="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        {columns.map((col, index) => {
                            return (
                                <th key={index} className="px-4 py-3">
                                    {" "}
                                    {col.headerName}
                                </th>
                            );
                        })}
                        {actionComponent && (
                            <th className="px-4 py-3">Actions</th>
                        )}
                    </tr>
                </thead>
                <tbody className="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    {data.data.map((row) => {
                        return (
                            <tr
                                key={rowKeyFunc ? rowKeyFunc(row) : row[rowKey]}
                                className="text-gray-700 dark:text-gray-400"
                            >
                                {columns.map((col, i) => {
                                    return (
                                        <td key={i} className="px-4 py-3">
                                            {getCellContent(i, col, row)}
                                        </td>
                                    );
                                })}
                                {actionComponent && (
                                    <td>
                                        <Action
                                            row={row}
                                            key={row[rowKey]}
                                            onChangeData={() => {
                                                Inertia.reload({
                                                    only: ["tickets"],
                                                });
                                            }}
                                        ></Action>
                                    </td>
                                )}
                            </tr>
                        );
                    })}
                </tbody>
            </table>
            <TablePaginationActions
                nextPageUrl={data.next_page_url}
                firstPageUrl={data.first_page_url}
                lastPageUrl={data.last_page_url}
                previousPageUrl={data.prev_page_url}
                currentPage={data.current_page}
                lastPage={data.last_page}
                rowPerPage={data.per_page}
                path={data.path}
                from={data.from ?? 0}
                to={data.to ?? 0}
                total={data.total ?? 0}
                handlePageChange={handlePageChange}
                handlePaninateByPageNumber={handlePaninateByPageNumber}
            />
        </>
    );
};
export default Datatable;
