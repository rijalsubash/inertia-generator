import { useState } from "react";
import DesktopNavigation from "./Navigation/Desktop";
import MobileNavigation from "./Navigation/Mobile";

const Sidebar = ({isNavbarOpen}) => {
    return (
        <>
            <DesktopNavigation />
            {isNavbarOpen && <MobileNavigation isNavbarOpen={isNavbarOpen} />}
           {/* {isNavbarOpen && <div className="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>} */}
        </>
    );
};

export default Sidebar;
