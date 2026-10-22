// src/app/pages/rider-view/rider-view.component.ts
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { DeliveryService } from '../../models/delivery.service';
import { RiderJob } from '../../models/delivery.model';

@Component({
  selector: 'app-rider-view',
  standalone: true,
  imports: [CommonModule, FormsModule],
  template: `
    <div class="max-w-md mx-auto p-4">
      <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

        <div class="bg-slate-900 text-white p-5">
          <div class="text-xs font-bold text-emerald-400 uppercase mb-1">
            🛵 หน้าจอใบงานไรเดอร์ (เปิดดูผ่านมือถือ)
          </div>
          <label class="block text-xs text-slate-300 mb-1">เลือกล็อกอินชื่อไรเดอร์:</label>
          <select
            [(ngModel)]="currentRiderId"
            (change)="onSelectRider()"
            class="w-full bg-slate-800 text-white font-bold px-3 py-2.5 rounded-xl border border-slate-700 text-sm">
            @for (job of allJobs; track job.riderId) {
              <option [ngValue]="job.riderId">
                {{ job.riderName }} (หยิบ {{ job.totalBoxes }} กล่อง / ส่ง {{ job.stops.length }} จุด)
              </option>
            }
          </select>
        </div>

        @if (!activeJob) {
          <div class="p-8 text-center space-y-3">
            <div class="text-4xl">⏳</div>
            <h3 class="font-bold text-slate-800">ยังไม่มีใบงานที่จัดเส้นทาง</h3>
            <p class="text-xs text-slate-500">
              กรุณาให้เจ้าของร้านกดปุ่ม <b>"จัดเส้นทาง"</b> ในหน้าจอเจ้าของร้านก่อนครับ
            </p>
            <button
              (click)="backToOwner()"
              class="bg-amber-500 text-slate-950 font-bold text-xs px-4 py-2.5 rounded-xl">
              กลับไปหน้าจอเจ้าของร้าน
            </button>
          </div>
        } @else {
          <div class="p-5 space-y-4">

            <div
              class="rounded-2xl p-4 text-white shadow flex items-center justify-between"
              [style.backgroundColor]="activeJob.routeColor">
              <div>
                <div class="text-xs opacity-90">วันนี้ต้องหยิบข้าวกล่องไปทั้งหมด</div>
                <div class="text-3xl font-extrabold">{{ activeJob.totalBoxes }} กล่อง</div>
                <div class="text-xs opacity-90 mt-1">
                  ส่งทั้งหมด {{ activeJob.stops.length }} จุด • ระยะทางรวม {{ activeJob.totalDistanceKm }} กม.
                </div>
              </div>
              <div class="text-5xl">🎒</div>
            </div>

            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-xs text-slate-700 leading-relaxed">
              <b class="text-slate-900">สรุปลำดับการวิ่ง:</b>
              @for (s of activeJob.stops; track s.step) {
                <span> จุดที่ {{ s.step }} ส่งบ้านคุณ {{ s.order.firstname }} -> </span>
              }
              <b class="text-emerald-700">เสร็จแล้วให้ขับกลับร้าน</b>
            </div>

            <div class="space-y-3">
              @for (stop of activeJob.stops; track stop.step) {
                <div
                  class="p-4 rounded-2xl border-2 space-y-2 transition"
                  [class]="stop.isCompleted ? 'bg-emerald-50 border-emerald-400 opacity-75' : 'bg-white border-slate-200'">

                  <div class="flex items-center justify-between">
                    <span
                      class="text-xs font-extrabold text-white px-2.5 py-1 rounded-lg"
                      [style.backgroundColor]="activeJob.routeColor">
                      จุดที่ {{ stop.step }}
                    </span>
                    <span class="text-xs font-semibold text-slate-600">
                      ถึง ~{{ stop.arrivalTimeText }} (ห่าง {{ stop.distanceKm }} กม.)
                    </span>
                  </div>

                  <div class="text-sm font-bold text-slate-900">
                    ต้องไปส่งบ้านคุณ {{ stop.order.firstname }} {{ stop.order.lastname }}
                  </div>

                  <div class="flex justify-between text-xs text-slate-600">
                    <span>🍱 จำนวน: <b class="text-slate-900">{{ stop.order.quantity }} กล่อง</b></span>
                    <span>📞 โทร: <a [href]="'tel:' + stop.order.phone" class="text-indigo-600 font-bold underline">{{ stop.order.phone }}</a></span>
                  </div>

                  <button
                    (click)="stop.isCompleted = !stop.isCompleted"
                    [class]="stop.isCompleted
                      ? 'w-full bg-emerald-600 text-white text-xs font-bold py-2.5 rounded-xl'
                      : 'w-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 rounded-xl'">
                    {{ stop.isCompleted ? '✓ ส่งเรียบร้อยแล้ว' : 'กดยืนยันเมื่อส่งจุดนี้เสร็จ' }}
                  </button>
                </div>
              }

              <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-300 text-xs flex items-center gap-3">
                <span class="bg-amber-500 text-slate-950 font-extrabold px-2.5 py-1 rounded-lg">จบงาน</span>
                <div>
                  <div class="font-bold text-slate-900">เสร็จแล้วให้ขับกลับร้านทันที</div>
                  <div class="text-slate-600">ระยะทางขากลับร้าน {{ activeJob.returnDistanceKm }} กม.</div>
                </div>
              </div>
            </div>

          </div>
        }
      </div>
    </div>
  `
})
export class RiderViewComponent implements OnInit {
  public allJobs: RiderJob[] = [];
  public currentRiderId: number = 1;
  public activeJob?: RiderJob;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private deliveryService: DeliveryService
  ) {}

  async ngOnInit(): Promise<void> {
    if (this.deliveryService.sharedRiderJobs.length === 0) {
      const customers = await this.deliveryService.getCustomers();
      const orders = await this.deliveryService.getOrders();
      this.deliveryService.calculateSmartRoutes(orders, customers);
    }

    this.allJobs = this.deliveryService.sharedRiderJobs;

    this.route.paramMap.subscribe((params) => {
      const idParam = Number(params.get('id')) || 1;
      this.currentRiderId = idParam;
      this.activeJob = this.allJobs.find((j) => j.riderId === this.currentRiderId) || this.allJobs[0];
    });
  }

  public onSelectRider(): void {
    this.router.navigate(['/rider', this.currentRiderId]);
  }

  public backToOwner(): void {
    this.router.navigate(['/owner']);
  }
}