import React from 'react'
import Anlyzeboxes from './Anlyzeboxes'
import './Adminpanel.scss'
import ResponsiveDateCalendar from '../ResponsiveDateCalendar'
import Charttable from '../charttable'
import Userstetus from '../Userstetus'
import Breadcumb from '../Breadcumb'



function Statics() {
  const breadcumbItems = [
    { label: 'Home', link: '#', icon: 'M19.707 9.293l-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z' },
    { label: 'Dashboard' },
  ];
  return (
    <div className='main'>
      <div className='left_sec'>
        <div style={{ width: '100%' }} className="flex justify-between items-center">
          <h3 style={{ fontSize: '25px', color: '#6a6b6b', fontFamily: '"Poppins", serif', }} className="m-4 font-semibold ml-5">
            Admin Dashboard
          </h3>
          <Breadcumb items={breadcumbItems} />
        </div>

        <Anlyzeboxes />
        <Charttable />
      </div>
      <div className='right_sec'>
        <ResponsiveDateCalendar />
        <Userstetus />
      </div>


    </div>
  )
}

export default Statics