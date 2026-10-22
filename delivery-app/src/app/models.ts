export interface Customer {   
    id?: number; 
    firstname: string; 
    lastname: string; 
    phone: string; 
    lat: number; 
    lng: number; 
}

export interface Order { 
    id: number; 
    quantity: 
    number; 
    order_date: string; 
    customer_id: number; 
    firstname: string; 
    lastname: string; 
    lat: number; 
    lng: number; 
}

export interface Stop { 
    name: string; 
    lat: number; 
    lng: number; 
    qty: number; 
    eta: string; 
    late: boolean; 
}

export interface RiderPlan { 
    no: number; 
    color: string; 
    boxes: number; 
    stops: Stop[]; 
    km: number; 
    minutes: number; 
    backEta: string; 
}

export interface Plan { 
    depot: { lat: number; lng: number }; 
    riders: RiderPlan[]; 
    createdAt: string; 
}
