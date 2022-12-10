import { usePage } from "@inertiajs/inertia-react";
import React, { useEffect, useState } from "react";
import NavLink from "./Navlink";


const MobileNavigation = ({icons, navLinkLists}) => {

    const getIconByName = (name) => {
        return icons.find((ic) => ic.name == name)?.default;
    };

    const page = usePage().props;
    return (
        <aside className="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden">
            <div className="py-4 text-gray-500 dark:text-gray-400">
                <a
                    className="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
                    href="#"
                >
                    {page.config.app_name}
                </a>
                <ul className="mt-6">
                    {navLinkLists.map((navItem, key) => {
                        let icon = getIconByName(navItem.icon_name);
                        return (
                            <NavLink
                                key={key}
                                active={route().current() === navItem.route}
                                href={route(navItem.route)}
                            >
                                {icon && <img width={20} src={icon}></img>}
                                <span className="ml-4">{navItem.label}</span>
                            </NavLink>
                        );
                    })}
                </ul>
                <div className="px-6 my-6">
                    <button className="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Example Button
                        <span className="ml-2" aria-hidden="true">
                            +
                        </span>
                    </button>
                </div>
            </div>
        </aside>
    );
};

export default MobileNavigation;
