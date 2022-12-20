import { useForm } from "@inertiajs/inertia-react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import Checkbox from "@/Components/Checkbox";
import Radio from "@/Components/Radio";
import Autocomplete from "@/Components/Autocomplete";
const MyStubTestField = ({ auth, pagedata = {}, toastData }) => {
    const { data, setData, processing, reset, errors, post, patch } = useForm({
        name: pagedata.name || "",
        description: pagedata.description || "",
        create_another: false,
        test: "",
        autocomplete: null,
    });
    const onHandleChange = (event, name = null) => {
        if (!event.target && name) {
            setData(name, event);
        } else {
            setData(
                event.target.name,
                event.target.type === "checkbox"
                    ? event.target.checked
                    : event.target.value
            );
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (pagedata.id) {
            patch(route("stubtest.update", pagedata.id));
        } else {
            post(route("stubtest.store"), {
                onSuccess: () => reset(),
            });
        }
    };
    return (
        <AuthenticatedLayout auth={auth} toastData={toastData}>
            <div className="container px-6 mx-auto grid">
                <div className="flex justify-between">
                    <div className="flex-none w-50">
                        <h2 className="font-semibold text-xl py-5 text-gray-800 leading-tight">
                            {pagedata.id
                                ? "Edit ID#" + pagedata.id
                                : "Create Pagedata"}
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
                            <div className="mt-4">
                                <Radio
                                    name="test"
                                    label="test"
                                    handleChange={onHandleChange}
                                    options={[
                                        { value: 1, label: "opt1" },
                                        { value: 2, label: "opt2" },
                                    ]}
                                    selectedVal={data.test}
                                />

                                <InputError
                                    message={errors.description}
                                    className="mt-2"
                                />
                            </div>
                            <div className="mt-4">
                                <InputLabel
                                    forInput="autocomplete"
                                    value="autocomplete"
                                />
                                <Autocomplete
                                    options={[
                                        { value: 1, label: "opt1" },
                                        { value: 2, label: "opt2" },
                                    ]}
                                    onChange={(val) => onHandleChange(val, "autocomplete")}
                                    selectedVal={data.autocomplete}
                                />

                                <InputError
                                    message={errors.autocomplete}
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
