import { Component, inject } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { PlannerService } from '../../planner.service';
import { RiderPlan } from '../../models';

@Component({
  selector: 'app-rider', standalone: true, imports: [FormsModule],
  templateUrl: './rider.component.html', styleUrl: './rider.component.css',
})
export class RiderComponent {
  private router = inject(Router);
  no = Number(inject(ActivatedRoute).snapshot.paramMap.get('no')) || 0;
  input = 1;
  rider: RiderPlan | undefined;
  mapUrl = '';

  constructor() {
    const plan = inject(PlannerService).load();
    this.rider = plan?.riders.find(r => r.no === this.no);
    if (plan && this.rider) {
      const d = `${plan.depot.lat},${plan.depot.lng}`, s = this.rider.stops;
      this.mapUrl = `https://www.google.com/maps/dir/?api=1&travelmode=driving&origin=${d}&destination=${d}` +
        `&waypoints=${s.map(x => x.lat + ',' + x.lng).join('|')}`;
    }
  }
  login() { this.router.navigate(['/rider', this.input]).then(() => location.reload()); }
  navTo(lat: number, lng: number) { return `https://www.google.com/maps/dir/?api=1&travelmode=driving&destination=${lat},${lng}`; }
}
