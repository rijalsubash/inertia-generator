import TestAction from "@/Components/Test/Action";
import PrimaryButton from "@/Components/PrimaryButton";
import Datatable from "@/Components/Utility/Table/Datatable";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/inertia-react";

export default function Test(props) {
    const columns = [{ field: "name", headerName: "Name" },{ field: "birth_date", headerName: "Birth Date" },];

    const handleCreate = (e) => {
        e.preventDefault();
        Inertia.get(route("tests.create"));
    };
    return (
        <AuthenticatedLayout auth={props.auth} toastData={props.toastData}>
            <Head title="Test" />
            <div className="container grid px-6 mx-auto">
                <div className="flex justify-between">
                    <div className="flex-none w-50">
                        <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                            Create Test
                        </h2>
                    </div>
                    <div className="flex-none w-50">
                        <PrimaryButton
                            className="my-6"
                            type="button"
                            onClick={handleCreate}
                        >
                            Create
                        </PrimaryButton>
                    </div>
                </div>
                <div className="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                    <div className="w-full overflow-x-auto">
                        <Datatable
                            columns={columns}
                            data={props.data}
                            actionComponent={TestAction}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
