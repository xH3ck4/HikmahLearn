import { useEffect, useState } from 'react';
import axios from 'axios';

const UserTable = () => {
    const [studentdata, setStudentdata] = useState([]);

    useEffect(() => {
        fetchUserDetails();
    }, []);

    const fetchUserDetails = async () => {
        try {
            const response = await axios.post('http://127.0.0.1:8000/api/getdataregister');

            setStudentdata(response.data.userdetails);
          

        } catch (error) {
            console.error("Error fetching user details:", error);
        }

    
    };


    return (
        <div>
            <div className="tablechart relative overflow-x-auto shadow-xl sm:rounded-lg m-5 mt-6">
                <div className="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white shadow-lg">
                    <div>
                        <button
                            id="dropdownActionButton"
                            data-dropdown-toggle="dropdownAction"
                            className="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 m-3"
                            type="button"
                        >
                            <span className="sr-only">Action button</span>
                            Action
                            <svg
                                className="w-2.5 h-2.5 ms-2.5"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 10 6"
                            >
                                <path
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="m1 1 4 4 4-4"
                                />
                            </svg>
                        </button>

                        <div
                            id="dropdownAction"
                            className="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44"
                        >
                            <ul className="py-1 text-sm text-gray-700" aria-labelledby="dropdownActionButton">
                                <li>
                                    <a href="#" className="block px-4 py-2 hover:bg-gray-100">Reward</a>
                                </li>
                                <li>
                                    <a href="#" className="block px-4 py-2 hover:bg-gray-100">Promote</a>
                                </li>
                                <li>
                                    <a href="#" className="block px-4 py-2 hover:bg-gray-100">Activate account</a>
                                </li>
                            </ul>
                            <div className="py-1">
                                <a href="#" className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Delete User
                                </a>
                            </div>
                        </div>
                    </div>

                    <label htmlFor="table-search" className="sr-only">
                        Search
                    </label>
                    <div className="relative m-3">
                        <div className="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg
                                className="w-4 h-4 text-gray-500"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    stroke="currentColor"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                />
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="table-search-users"
                            className="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search for users"
                        />
                    </div>
                </div>

                <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" className="p-4">
                                <div className="flex items-center">
                                    <input
                                        id="checkbox-all-search"
                                        type="checkbox"
                                        className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600"
                                    />
                                    <label htmlFor="checkbox-all-search" className="sr-only">
                                        checkbox
                                    </label>
                                </div>
                            </th>
                            <th scope="col" className="px-6 py-3">
                                id
                            </th>
                            <th scope="col" className="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" className="px-6 py-3">
                                Selected Course
                            </th>
                            <th scope="col" className="px-6 py-3">
                                Role
                            </th>
                            <th scope="col" className="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        {studentdata.map((user) => (
                            <tr className="bg-white border-b" key={user.id}>
                                <td className="w-4 p-4">
                                    <div className="flex items-center">
                                        <input
                                            id={`checkbox-table-search-${user.id}`}
                                            type="checkbox"
                                            className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                        />
                                        <label
                                            htmlFor={`checkbox-table-search-${user.id}`}
                                            className="sr-only"
                                        >
                                            checkbox
                                        </label>
                                    </div>
                                </td>
                                <td className="px-6 py-4">{user.id}</td>
                                <th scope="row" className="flex items-center px-6 py-4">
                                    <div class="relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                        <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <div className="ps-3">
                                        <div className="text-base font-semibold">{user.fname} {user.lname}</div>
                                        <div className="font-normal text-gray-500">{user.email}</div>
                                    </div>
                                </th>
                                <td className="px-6 py-4">{user.corce}</td>
                                <td className="px-6 py-4">
                                    <div className="flex items-center">
                                        {/* <div className="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> Online */}
                                        <div className="font-normal text-gray-500">{user.role}</div>
                                    </div>
                                </td>
                                <td className="px-6 py-4">
                                    <a href="#" className="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Edit user
                                    </a>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default UserTable;
