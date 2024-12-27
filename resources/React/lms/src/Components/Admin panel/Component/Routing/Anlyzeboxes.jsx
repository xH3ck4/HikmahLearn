import React, { useEffect, useState } from 'react'
import '../Routing/Adminpanel.scss';
import axios from 'axios';


function Anlyzeboxes() {
    const [studentCount, setstudentCount] = useState(0);


    useEffect(() => {
        const fetchStudentCount = async () => {
            try {
                const response = await axios.post('http://localhost:8000/api/Count');
                setstudentCount(response.data.count);
            }
            catch {
                console.error('Failed to fetch student count:');
            }
        }
        fetchStudentCount(); 
    }, [])
    return (
        <div className='Boxes'>
            <ul  className="box-info">
                <li>
                    <i  className='bx bxs-group' ></i>
                    <span  className="text">
                        <h3>{studentCount}</h3>
                        <p>Student</p>
                    </span>
                </li>
                <li>
                    <i  className='bx bxs-calendar-check' ></i>
                    <span className="text">
                        <h3>0</h3>
                        <p>Task</p>
                    </span>
                </li>
                <li>
                    <i  className='bx bxs-calendar-check' ></i>
                    <span  className="text">
                        <h3>0</h3>
                        <p>Online</p>
                    </span>
                </li>
            </ul>
        </div>
    )
}

export default Anlyzeboxes