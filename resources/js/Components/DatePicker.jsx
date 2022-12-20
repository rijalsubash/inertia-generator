import ReactDatePicket from "react-tailwindcss-datepicker";
export default function DatePicker({onChange, value=null}) {
    return (
        <ReactDatePicket
            asSingle={true}
            value={value}
            onChange={onChange}
        />
    );
}
