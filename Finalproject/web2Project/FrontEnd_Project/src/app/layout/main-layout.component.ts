import { Component } from '@angular/core';
import { RouterOutlet, RouterLink, RouterLinkActive } from '@angular/router';

@Component({
  selector: 'app-main-layout',
  standalone: true,
  imports: [RouterOutlet, RouterLink, RouterLinkActive],
  template: `
    <div class="min-h-screen flex flex-col bg-slate-100 text-slate-800">
      <!-- Navbar หลักของระบบ -->
      <header class="bg-slate-900 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-wrap items-center justify-between gap-3">
          <div class="flex items-center gap-3">
            <span class="text-3xl">🍱</span>
            <div>
              <h1 class="text-lg md:text-xl font-bold text-amber-400">
                ข้าวกล่องเดลิเวอรี ส่งด่วนมื้อเที่ยง
              </h1>
              <p class="text-xs text-slate-300">
                เวลาส่ง 11:30 - 12:30 น. (ภายใน 1 ชม.) • จุสูงสุด 10 กล่อง/คัน • ป้องกันค่าปรับ 20 บ./ออเดอร์
              </p>
            </div>
          </div>

          <!-- ลิงก์เปลี่ยนหน้าด้วย Angular Router -->
          <nav class="flex bg-slate-800 p-1 rounded-xl border border-slate-700 gap-1">
            <a
              routerLink="/owner"
              routerLinkActive="bg-amber-500 text-slate-950 font-bold shadow"
              class="px-4 py-2 rounded-lg text-sm text-slate-200 hover:text-white transition">
              🖥️ 1. หน้าจอเจ้าของร้าน
            </a>
            <a
              routerLink="/rider/1"
              routerLinkActive="bg-emerald-500 text-slate-950 font-bold shadow"
              class="px-4 py-2 rounded-lg text-sm text-slate-200 hover:text-white transition">
              📱 2. หน้าจอมือถือไรเดอร์
            </a>
          </nav>
        </div>
      </header>

      <!-- จุดแสดงผล Nested Routes (OwnerDashboard หรือ RiderView) -->
      <div class="flex-1">
        <router-outlet></router-outlet>
      </div>
    </div>
  `
})
export class MainLayoutComponent {}