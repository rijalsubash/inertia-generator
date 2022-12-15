import { useForm } from "@inertiajs/inertia-react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import Checkbox from "@/Components/Checkbox";
import { toast } from "react-toastify";
const MyStubTestField = ({ auth, pagedata = {} }) => {
    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        errors,
        post,
        patch,
    } = useForm({
        name: pagedata.name || "",
        description: pagedata.description || "",
        create_another: false,
    });
    const onHandleChange = (event) => {
        setData(
            event.target.name,
            event.target.type === "checkbox"
                ? event.target.checked
                : event.target.value
        );
    };
    const options = {
        onSuccess: () => toast.success("Saved successfully"),
        onerror: () => toast.error("Cannot save the changes"),
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        toast.success("Saved successfully")
        if (pagedata.id) {
            patch(route("stubtest.update", pagedata.id), {
                onSuccess: () => toast.success("Saved successfully"),
                onerror: () => toast.error("Cannot save the changes"),
            });
        } else {
            post(route("stubtest.store"), {
                onSuccess: () => toast.success("Saved successfully"),
                onerror: () => toast.error("Cannot save the changes"),
            });
        }
    };
    return (
        <AuthenticatedLayout auth={auth}>
            <div className="container px-6 mx-auto grid">
                <div className="flex justify-between">
                    <div className="flex-none w-50">
                        <h2 className="font-semibold text-xl py-5 text-gray-800 leading-tight">
                            Create My Stub
                        </h2>
                    </div>
                </div>
                <div className="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <form onSubmit={handleSubmit}>
                        <div className="flex flex-col md:flex-row  md:gap-4">
                            <div className="mt-4">
                                <InputLabel forInput="name" value="Name" />

                                <TextInput
                                    id="name"
                                    name="name"
                                    value={data.name}
                                    className="mt-1 block w-full"
                                    autoComplete="name"
                                    isFocused={true}
                                    handleChange={onHandleChange}
                                />

                                <InputError
                                    message={errors.name}
                                    className="mt-2"
                                />
                            </div>

                            <div className="mt-4 ">
                                <InputLabel
                                    forInput="description"
                                    value="description"
                                />

                                <TextInput
                                    id="description"
                                    type="text"
                                    name="description"
                                    value={data.description}
                                    className="mt-1 block w-full"
                                    autoComplete="username"
                                    handleChange={onHandleChange}
                                />

                                <InputError
                                    message={errors.description}
                                    className="mt-2"
                                />
                            </div>
                        </div>
                        <div className=" flex my-4 w-100">
                            <PrimaryButton processing={processing}>
                                Submit
                            </PrimaryButton>
                            {!pagedata.id && (
                                <div className="block mx-4 mt-2">
                                    <label className="flex items-center">
                                        <Checkbox
                                            name="create_another"
                                            value={data.create_another}
                                            handleChange={onHandleChange}
                                        />
                                        <span className="ml-2 text-sm text-gray-600">
                                            Create Another
                                        </span>
                                    </label>
                                </div>
                            )}
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default MyStubTestField;
