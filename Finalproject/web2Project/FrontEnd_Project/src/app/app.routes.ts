import { Routes } from '@angular/router';
import { MainLayoutComponent } from './layout/main-layout.component';
import { OwnerDashboardComponent } from './pages/owner-dashboard/owner-dashboard.components';
import { RiderViewComponent } from './pages/rider-view/rider-view.components';

export const routes: Routes = [
  {
    path: '',
    component: MainLayoutComponent, // Layout หลัก
    children: [                     // Nested Routes
      { path: '', redirectTo: 'owner', pathMatch: 'full' },
      { path: 'owner', component: OwnerDashboardComponent },
      { path: 'rider', component: RiderViewComponent },
      { path: 'rider/:id', component: RiderViewComponent } // Dynamic path parameter (:id)
    ]
  }
];