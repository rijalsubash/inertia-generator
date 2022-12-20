import DeleteButton from "../Utility/Action/DeleteButton";
import EditButton from "../Utility/Action/EditButton";

const TestAction = ({ row }) => {
    return (
        <div className="flex gap-1">
            <EditButton url={route("tests.edit", row.id)}/>
            <DeleteButton url={route('tests.destroy', row.id)}/>
        </div>
    );
};

export default TestAction;
