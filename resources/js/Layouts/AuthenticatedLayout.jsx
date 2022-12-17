import Header from "@/Components/Layout/Header";
import Sidebar from "@/Components/Layout/Sidebar";
import { useEffect, useState } from "react";
import { toast, ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

export default function Authenticated({ auth, header, children, toastData }) {
    const [isNavbarOpen, setIsNavbarOpen] = useState(false);
    useEffect(() => {
        if (toastData) {
            console.log(toastData.message)
            if(!toastData.type || toastData.type =='success'){
                toast.success(toastData.message)
            }else{
                toast.error(toastData.message)
            }
        }
    }, [toastData]);
    return (
        <>
            <div className="flex h-screen bg-gray-50 dark:bg-gray-900 overflow-hidden">
                <Sidebar
                    setIsNavbarOpen={setIsNavbarOpen}
                    isNavbarOpen={isNavbarOpen}
                />
                <div className="flex flex-col flex-1 w-full">
                    <Header
                        auth={auth}
                        toogleNavigation={() => setIsNavbarOpen(!isNavbarOpen)}
                    />
                    <main className="h-full overflow-y-auto">{children}</main>
                </div>
            </div>
            <ToastContainer />
        </>
    );
}
