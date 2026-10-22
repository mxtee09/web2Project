import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { lastValueFrom } from 'rxjs';
import { Constants } from '../config/constants';
import { Customer, Order, RiderJob, RiderStop } from '../models/delivery.model';

@Injectable({
  providedIn: 'root'
})
export class DeliveryService {
  public sharedRiderJobs: RiderJob[] = [];
  public sharedCustomers: Customer[] = [];
  public sharedOrders: Order[] = [];

  private readonly routeColors: string[] = [
    '#EF4444', 
    '#10B981', 
    '#3B82F6', 
    '#F59E0B', 
    '#8B5CF6', 
    '#EC4899', 
    '#14B8A6'  
  ];

  constructor(private http: HttpClient) {}


  public async createCustomer(customer: Customer): Promise<Customer> {
    const url = `${Constants.API_ENDPOINT}/customers`;
    return await lastValueFrom(this.http.post<Customer>(url, customer));
  }

  public async getCustomers(): Promise<Customer[]> {
    const url = `${Constants.API_ENDPOINT}/customers`;
    this.sharedCustomers = await lastValueFrom(this.http.get<Customer[]>(url));
    return this.sharedCustomers;
  }

  public async updateCustomer(id: number, customer: Customer): Promise<any> {
    const url = `${Constants.API_ENDPOINT}/customers/${id}`;
    return await lastValueFrom(this.http.put(url, customer));
  }

  public async deleteCustomer(id: number): Promise<any> {
    const url = `${Constants.API_ENDPOINT}/customers/${id}`;
    return await lastValueFrom(this.http.delete(url));
  }

  public async searchCustomerByKeyword(keyword: string): Promise<Customer[]> {
    const url = `${Constants.API_ENDPOINT}/customers/search?keyword=${encodeURIComponent(keyword)}`;
    return await lastValueFrom(this.http.get<Customer[]>(url));
  }

  public async getNearbyCustomers(lat: number, lng: number): Promise<{ total: number; data: Customer[] }> {
    const url = `${Constants.API_ENDPOINT}/customers/nearby?lat=${lat}&lng=${lng}`;
    return await lastValueFrom(this.http.get<{ total: number; data: Customer[] }>(url));
  }

  public async generateMockOrders(): Promise<any> {
    const url = `${Constants.API_ENDPOINT}/orders/mock`;
    return await lastValueFrom(this.http.post(url, {}));
  }

  public async createOrder(customer_id: number, quantity: number): Promise<any> {
    const url = `${Constants.API_ENDPOINT}/orders`;
    return await lastValueFrom(this.http.post(url, { customer_id, quantity }));
  }

  public async getOrders(): Promise<Order[]> {
    const url = `${Constants.API_ENDPOINT}/orders`;
    this.sharedOrders = await lastValueFrom(this.http.get<Order[]>(url));
    return this.sharedOrders;
  }

  public async updateOrderQuantity(id: number, quantity: number): Promise<any> {
    const url = `${Constants.API_ENDPOINT}/orders/${id}`;
    return await lastValueFrom(this.http.put(url, { quantity }));
  }

  public async deleteOrder(id: number): Promise<any> {
    const url = `${Constants.API_ENDPOINT}/orders/${id}`;
    return await lastValueFrom(this.http.delete(url));
  }

  public async clearAllOrders(): Promise<any> {
    const url = `${Constants.API_ENDPOINT}/orders/clear-all`;
    return await lastValueFrom(this.http.delete(url));
  }

  public async getNearbyOrders(lat: number, lng: number): Promise<{ total: number; data: Order[] }> {
    const url = `${Constants.API_ENDPOINT}/orders/nearby?lat=${lat}&lng=${lng}`;
    return await lastValueFrom(this.http.get<{ total: number; data: Order[] }>(url));
  }


  public calculateHaversineKm = (lat1: number, lon1: number, lat2: number, lon2: number): number => {
    const R = 6371;
    const dLat = ((lat2 - lat1) * Math.PI) / 180;
    const dLon = ((lon2 - lon1) * Math.PI) / 180;
    const a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos((lat1 * Math.PI) / 180) *
        Math.cos((lat2 * Math.PI) / 180) *
        Math.sin(dLon / 2) *
        Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return Number((R * c).toFixed(2));
  };

  public calculateSmartRoutes(orders: Order[], customers: Customer[]): RiderJob[] {
    if (orders.length === 0) {
      this.sharedRiderJobs = [];
      return [];
    }

    const avgLat = orders.reduce((sum, item) => sum + Number(item.lat), 0) / orders.length;
    const avgLng = orders.reduce((sum, item) => sum + Number(item.lng), 0) / orders.length;
    Constants.SHOP_LAT = Number(avgLat.toFixed(4));
    Constants.SHOP_LNG = Number(avgLng.toFixed(4));

    const enrichedOrders: Order[] = orders.map((order) => {
      const foundCustomer = customers.find((c) => c.id === order.customer_id);
      return {
        ...order,
        phone: foundCustomer ? foundCustomer.phone : '08X-XXX-XXXX'
      };
    });

    const sortedByZone = [...enrichedOrders].sort((a, b) => {
      const angleA = Math.atan2(a.lat - Constants.SHOP_LAT, a.lng - Constants.SHOP_LNG);
      const angleB = Math.atan2(b.lat - Constants.SHOP_LAT, b.lng - Constants.SHOP_LNG);
      return angleA - angleB;
    });

    const jobs: RiderJob[] = [];
    let riderNumber = 0;

    while (sortedByZone.length > 0) {
      riderNumber++;
      let currentBoxes = 0;
      let currentLat = Constants.SHOP_LAT;
      let currentLng = Constants.SHOP_LNG;
      let totalDistKm = 0;
      let totalTimeMin = 0;
      const stops: RiderStop[] = [];

      const firstOrder = sortedByZone.shift()!;
      const firstDist = this.calculateHaversineKm(currentLat, currentLng, firstOrder.lat, firstOrder.lng);
      const firstTravelMin = (firstDist / 30) * 60 + 3; 

      currentBoxes += Number(firstOrder.quantity);
      totalDistKm += firstDist;
      totalTimeMin += firstTravelMin;
      currentLat = firstOrder.lat;
      currentLng = firstOrder.lng;

      stops.push(
        new RiderStop(
          1,
          firstOrder,
          firstDist,
          Math.round(totalTimeMin),
          this.formatClockTime(11, 30, totalTimeMin)
        )
      );

      
      while (sortedByZone.length > 0) {
        let bestIndex = -1;
        let minDistance = Infinity;

        for (let i = 0; i < sortedByZone.length; i++) {
          const candidate = sortedByZone[i];
          if (currentBoxes + Number(candidate.quantity) <= Constants.MAX_BOXES_PER_RIDER) {
            const dist = this.calculateHaversineKm(currentLat, currentLng, candidate.lat, candidate.lng);
            const nextTimeMin = totalTimeMin + (dist / 30) * 60 + 3;

            if (nextTimeMin <= Constants.MAX_TIME_MINUTES && dist < minDistance) {
              minDistance = dist;
              bestIndex = i;
            }
          }
        }

        if (bestIndex !== -1) {
          const nextOrder = sortedByZone.splice(bestIndex, 1)[0];
          const stepTimeMin = (minDistance / 30) * 60 + 3;

          currentBoxes += Number(nextOrder.quantity);
          totalDistKm += minDistance;
          totalTimeMin += stepTimeMin;
          currentLat = nextOrder.lat;
          currentLng = nextOrder.lng;

          stops.push(
            new RiderStop(
              stops.length + 1,
              nextOrder,
              minDistance,
              Math.round(totalTimeMin),
              this.formatClockTime(11, 30, totalTimeMin)
            )
          );
        } else {
          break;
        }
      }

      const returnDist = this.calculateHaversineKm(
        currentLat,
        currentLng,
        Constants.SHOP_LAT,
        Constants.SHOP_LNG
      );

      const color = this.routeColors[(riderNumber - 1) % this.routeColors.length];

      jobs.push(
        new RiderJob(
          riderNumber,
          `ไรเดอร์คนที่ ${riderNumber}`,
          color,
          currentBoxes,
          Number(totalDistKm.toFixed(2)),
          returnDist,
          Math.round(totalTimeMin),
          stops
        )
      );
    }

    this.sharedRiderJobs = jobs;
    return jobs;
  }

  private formatClockTime(startHour: number, startMin: number, addMinutes: number): string {
    const total = startHour * 60 + startMin + Math.round(addMinutes);
    const hh = Math.floor(total / 60) % 24;
    const mm = total % 60;
    return `${hh.toString().padStart(2, '0')}:${mm.toString().padStart(2, '0')} น.`;
  }
}