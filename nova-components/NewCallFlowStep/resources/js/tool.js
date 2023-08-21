import Tool from './pages/Tool'

Nova.booting((app, store) => {
    //  Nova.inertia('NewCallFlowStep', Tool)
    Nova.inertia('new-call-flow-step/{id}', Tool)
})

