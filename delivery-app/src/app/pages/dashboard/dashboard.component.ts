import { Component, AfterViewInit, OnDestroy, inject, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import * as L from 'leaflet';
import { ApiService } from '../../api.service';
import { PlannerService } from '../../planner.service';
import { Plan } from '../../models';

@Component({
  selector: 'app-dashboard', standalone: true, imports: [FormsModule],
  templateUrl: './dashboard.component.html', styleUrl: './dashboard.component.css',
})
export class DashboardComponent implements AfterViewInit, OnDestroy {
  private api = inject(ApiService);
  private planner = inject(PlannerService);
  private map!: L.Map;
  private layer = L.layerGroup();
  plan = signal<Plan | null>(this.planner.load());
  msg = signal('');
  depot = { lat: 16.2466, lng: 103.2550 };   // พิกัดร้าน: แก้ได้ในหน้าเว็บ
  riders = 3;

  ngAfterViewInit() {
    this.map = L.map('map').setView([this.depot.lat, this.depot.lng], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(this.map);
    this.layer.addTo(this.map);
    if (this.plan()) this.draw(this.plan()!); else this.drawDepot();
  }
  ngOnDestroy() { this.map?.remove(); }

  generate() {
    this.msg.set('กำลังคำนวณ...');
    this.api.getOrders().subscribe({
      next: orders => {
        if (!orders.length) return this.msg.set('ยังไม่มีออเดอร์');
        const p = this.planner.plan(orders, this.depot, this.riders);
        this.planner.save(p); this.plan.set(p); this.draw(p);
        this.msg.set(`จัดแล้ว: ${p.riders.length} คัน`);
      },
      error: e => this.msg.set('ผิดพลาด: ' + (e.error?.error ?? e.message)),
    });
  }
  mock() { this.api.mockOrders().subscribe(() => this.msg.set('สร้างข้อมูลจำลองแล้ว')); }
  clear() {
    if (!confirm('ล้างออเดอร์ทั้งหมด?')) return;
    this.api.clearOrders().subscribe({
      next: () => {
        this.planner.clear();          // ลบแผนที่เก็บไว้
        this.plan.set(null);           // ซ่อนตารางสรุป
        this.layer.clearLayers();      // ลบเส้นและหมุดบนแผนที่
        this.drawDepot();
        this.map.setView([this.depot.lat, this.depot.lng], 13);
        this.msg.set('ล้างออเดอร์และเส้นทางแล้ว');
      },
      error: e => this.msg.set('ผิดพลาด: ' + (e.error?.error ?? e.message)),
    });
  }

  private draw(p: Plan) {
    this.layer.clearLayers();
    this.drawDepot();
    const bounds: L.LatLngExpression[] = [[p.depot.lat, p.depot.lng]];
    for (const r of p.riders) {
      const line: L.LatLngExpression[] = [[p.depot.lat, p.depot.lng], ...r.stops.map(s => [s.lat, s.lng] as L.LatLngExpression), [p.depot.lat, p.depot.lng]];
      L.polyline(line, { color: r.color, weight: 4 }).addTo(this.layer);
      r.stops.forEach((s, i) => {
        L.circleMarker([s.lat, s.lng], { radius: 8, color: r.color, fillColor: '#fff', fillOpacity: 1 })
          .bindTooltip(`${i + 1}`, { permanent: true, direction: 'center', className: 'num' })
          .bindPopup(`ไรเดอร์ ${r.no} จุด ${i + 1}: ${s.name} (${s.qty} กล่อง) ถึง ${s.eta}`).addTo(this.layer);
        bounds.push([s.lat, s.lng]);
      });
    }
    this.map.fitBounds(L.latLngBounds(bounds), { padding: [30, 30] });
  }

  private drawDepot() {
    L.circleMarker([this.depot.lat, this.depot.lng], { radius: 10, color: '#000', fillColor: '#ffeb3b', fillOpacity: 1 })
      .bindTooltip('ร้าน').addTo(this.layer);
  }
}

