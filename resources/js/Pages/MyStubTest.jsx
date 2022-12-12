import Datatable from "@/Components/Utility/Table/Datatable";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/inertia-react";

export default function MyStubTest(props) {
    const columns = [
        { field: "name", headerName: "Name" },
        { field: "description", headerName: "Description" },
        {
            headerName: "Created_at",
            computed: (row) => `${row.created_at}`,
        },
        {
            headerName: "updated At",
            computed: (row) => `${row.updated_at} m`,
        },
    ];
    return (
        <AuthenticatedLayout
            auth={props.auth}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard
                </h2>
            }
            // errors={props.errors}
        >
            <Head title="Dashboard" />
            <div className="container grid px-6 mx-auto">
                <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Table
                </h2>
                <div className="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                    <div className="w-full overflow-x-auto">
                        <Datatable columns={columns} data={props.data} />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
