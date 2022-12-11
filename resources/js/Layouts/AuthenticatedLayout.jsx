import Header from "@/Components/Layout/Header";
import Sidebar from "@/Components/Layout/Sidebar";
import { useState } from "react";

export default function Authenticated({ auth, header, children }) {
    const [isNavbarOpen, setIsNavbarOpen] = useState(false);

    return (
        <>
            <div className="flex h-screen bg-gray-50 dark:bg-gray-900 overflow-hidden">
                <Sidebar
                    setIsNavbarOpen={setIsNavbarOpen}
                    isNavbarOpen={isNavbarOpen}
                />
                <div className="flex flex-col flex-1 w-full">
                    <Header auth={auth}
                        toogleNavigation={() => setIsNavbarOpen(!isNavbarOpen)}
                    />
                    <main className="h-full overflow-y-auto">{children}</main>
                </div>
            </div>
        </>
    );
}
