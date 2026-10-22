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
  quantity: number;
  order_date: string;
  customer_id: number;
  firstname: string;
  lastname: string;
  lat: number;
  lng: number;
  phone?: string;
}

export class RiderStop {
  constructor(
    public step: number,
    public order: Order,
    public distanceKm: number,
    public cumulativeMinutes: number,
    public arrivalTimeText: string,
    public isCompleted: boolean = false
  ) {}
}

export class RiderJob {
  constructor(
    public riderId: number,
    public riderName: string,
    public routeColor: string,
    public totalBoxes: number,
    public totalDistanceKm: number,
    public returnDistanceKm: number,
    public totalMinutes: number,
    public stops: RiderStop[]
  ) {}
}