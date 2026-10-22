import { Routes } from '@angular/router';
import { CustomersComponent } from './pages/customers/customers.component';
import { DashboardComponent } from './pages/dashboard/dashboard.component';
import { RiderComponent } from './pages/rider/rider.component';

export const routes: Routes = [
  { path: '', redirectTo: 'dashboard', pathMatch: 'full' },
  { path: 'customers', component: CustomersComponent },
  { path: 'dashboard', component: DashboardComponent },
  { path: 'rider', component: RiderComponent },          // หน้าล็อกอินไรเดอร์
  { path: 'rider/:no', component: RiderComponent },      // ใบงานไรเดอร์
  { path: '**', redirectTo: 'dashboard' },
];
