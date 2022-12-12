import MyStubTestAction from "@/Components/MyStubTest/Action";
import PrimaryButton from "@/Components/PrimaryButton";
import Datatable from "@/Components/Utility/Table/Datatable";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Inertia } from "@inertiajs/inertia";
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

    const handleCreate = (e)=> {
        e.preventDefault()
        Inertia.get(route('stubtest.create'))
    }
    return (
        <AuthenticatedLayout auth={props.auth}>
            <Head title="My Stub Test" />
            <div className="container grid px-6 mx-auto">
                <div className="flex justify-between">
                    <div className="flex-none w-50">
                        <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                            Create My Stub
                        </h2>
                    </div>
                    <div className="flex-none w-50">
                        <PrimaryButton className="my-6" type="button" onClick={handleCreate}>
                            Create
                        </PrimaryButton>
                    </div>
                </div>
                <div className="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                    <div className="w-full overflow-x-auto">
                        <Datatable
                            columns={columns}
                            data={props.data}
                            actionComponent={MyStubTestAction}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
