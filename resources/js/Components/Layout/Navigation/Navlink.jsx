import { Link } from "@inertiajs/inertia-react";

const NavLink = ({ href, active = false, children }) => {
    return (
        <li className="relative px-6 py-3">
         {active &&   <span
                className="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
            ></span>}
            <Link
                className={
                    "inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 " +
                    (active ? "text-gray-800" : "")
                }
                href={href}
            >
                {children}
            </Link>
        </li>
    );
};
export default NavLink;
