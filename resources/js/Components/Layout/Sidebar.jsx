import { useEffect, useState } from "react";
import DesktopNavigation from "./Navigation/Desktop";
import MobileNavigation from "./Navigation/Mobile";
import navLinkLists from "./Navigation/navlist.json";

const Sidebar = ({ isNavbarOpen, setIsNavbarOpen }) => {
    const [icons, setIcons] = useState([]);
    const myAllIcons = import.meta.glob("./icons/**/*.svg");
    const setIconList = async (navLinkLists) => {
        navLinkLists.forEach((navLnk) => {
            if(typeof myAllIcons["./icons/" + navLnk.icon_name + ".svg"] === 'function'){
                myAllIcons["./icons/" + navLnk.icon_name + ".svg"]().then(
                    (icPath) => {
                        setIcons((oldValue) => [
                            ...oldValue,
                            { ...icPath, name: navLnk.icon_name },
                        ]);
                    }
                );
            }
        });
    };

    useEffect(() => {
        setIconList(navLinkLists);
    }, []);

    return (
        <>
            <DesktopNavigation icons={icons} navLinkLists={navLinkLists} />
            {isNavbarOpen && (
                <MobileNavigation
                    navLinkLists={navLinkLists}
                    icons={icons}
                    isNavbarOpen={isNavbarOpen}
                />
            )}
            {isNavbarOpen && (
                <div
                    onClick={() => setIsNavbarOpen(false)}
                    className="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
                ></div>
            )}
        </>
    );
};

export default Sidebar;
