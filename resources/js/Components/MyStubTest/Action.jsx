import { Link } from "@inertiajs/inertia-react";
import DeleteButton from "../Utility/Action/DeleteButton";
import EditButton from "../Utility/Action/EditButton";

const MyStubTestAction = ({ row }) => {
    return (
        <div className="flex gap-1">
            <EditButton url={route("stubtest.edit", row.id)}/>
            <DeleteButton url={route('stubtest.destroy', row.id)}/>
        </div>
    );
};

export default MyStubTestAction;
