<?php

declare(strict_types=1);

$plugins = [
    [
        'name' => 'Overconda Conflict Detective',
        'slug' => 'overconda-conflict-detective',
        'badge' => 'Active Development',
        'badge_variant' => 'emerald',
        'description' => 'The ultimate tool to identify and resolve plugin/theme conflicts in seconds.',
        'tags' => ['Conflict Scanner', 'Debugging', 'Performance'],
    ],
    // Add more plugins here in the future – the UI will render them automatically.
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overconda | WordPress Plugin Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-50 antialiased">
    <header class="border-b border-slate-800/80 bg-slate-950/70 backdrop-blur">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 via-cyan-400 to-emerald-400 text-slate-950 font-semibold shadow-lg shadow-cyan-500/30">
                    O
                </span>
                <div>
                    <h1 class="text-base md:text-lg font-semibold tracking-tight">
                        กึ่งยิงกึ่งผ่าน (Overconda)
                    </h1>
                    <p class="text-[11px] md:text-xs text-slate-400">
                        Developer &amp; Content Creator · IT &amp; WordPress Development
                    </p>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-sm text-slate-300">
                <a href="#hero" class="hover:text-cyan-300 transition-colors">About</a>
                <a href="#core-concept" class="hover:text-cyan-300 transition-colors">Core Concept</a>
                <a href="#plugins" class="hover:text-cyan-300 transition-colors">WordPress Plugins</a>
                <a href="#contact" class="hover:text-cyan-300 transition-colors">Contact</a>
                <a
                    href="/license-validation.php"
                    class="inline-flex items-center gap-2 rounded-full border border-cyan-500/60 bg-cyan-500/10 px-3 py-1 text-[11px] font-semibold text-cyan-200 hover:bg-cyan-500/20 hover:border-cyan-400 transition-colors"
                >
                    License Validation
                    <span aria-hidden="true" class="text-[13px]">↗</span>
                </a>
            </nav>
            <div class="md:hidden">
                <a
                    href="/license-validation.php"
                    class="inline-flex items-center gap-1 rounded-full border border-cyan-500/60 bg-cyan-500/10 px-3 py-1 text-[11px] font-semibold text-cyan-200 hover:bg-cyan-500/20 hover:border-cyan-400 transition-colors"
                >
                    License
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-10 space-y-16">
        <!-- Hero -->
        <section id="hero" class="grid md:grid-cols-[minmax(0,3fr)_minmax(0,2fr)] gap-10 items-center">
            <div class="space-y-5">
                <p class="text-xs font-mono uppercase tracking-[0.2em] text-cyan-400/80">
                    WordPress Plugins · Problem Solving First
                </p>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-semibold tracking-tight">
                    สร้างเครื่องมือ WordPress<br class="hidden sm:block">
                    เพื่อแก้ปัญหา<span class="text-cyan-400">จริง</span>บนโลก IT
                </h2>
                <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                    ผมคือ <span class="font-semibold text-slate-100">กึ่งยิงกึ่งผ่าน (Overconda)</span> – Developer &amp; Content Creator
                    ที่โฟกัสด้าน <span class="text-cyan-300">IT Infrastructure, WordPress Development</span>
                    และการออกแบบปลั๊กอินที่ช่วยจับปัญหาให้ชัด ก่อนลงมือแก้ให้จบ.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#plugins" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-cyan-400 via-sky-400 to-emerald-400 px-5 py-2 text-sm font-semibold text-slate-950 shadow-lg shadow-cyan-500/40 hover:brightness-110 transition">
                        Explore WordPress Plugins
                    </a>
                    <a href="#contact" class="inline-flex items-center gap-2 rounded-full border border-slate-700 px-5 py-2 text-sm font-semibold text-slate-100 hover:border-cyan-400 hover:text-cyan-200 transition">
                        Work with Overconda
                    </a>
                </div>
                <div class="flex flex-wrap gap-4 text-[11px] text-slate-400">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Focus: WordPress Plugins, Automation, Observability
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                        Content: DevOps, Hosting, Plugin Best Practices
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-sky-900/80 bg-gradient-to-br from-slate-950 via-slate-950 to-sky-950/40 p-5 md:p-6 shadow-[0_0_80px_rgba(56,189,248,0.25)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-[11px] font-mono text-slate-400">
                        POST <span class="text-slate-200">/api/license/validate</span>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-emerald-500/10 px-2.5 py-0.5 text-[11px] font-medium text-emerald-300 border border-emerald-500/40">
                        Licensing &amp; Support Ready
                    </span>
                </div>
                <pre class="text-[11px] md:text-xs leading-relaxed font-mono text-slate-200 bg-slate-950/70 rounded-lg border border-slate-800 p-4 overflow-auto">
POST /api/validate
Content-Type: application/json

{
  "license_key": "XXXX-XXXX-XXXX-XXXX"
}</pre>
                <div class="mt-4 flex items-center justify-between gap-3">
                    <a
                        href="/license-validation.php"
                        class="inline-flex items-center gap-2 rounded-full bg-cyan-500/15 px-3 py-1.5 text-[11px] font-medium text-cyan-200 hover:bg-cyan-500/25 border border-cyan-500/50 transition-colors"
                    >
                        Open License Validation Console
                        <span aria-hidden="true" class="text-[13px]">↗</span>
                    </a>
                    <span class="text-[10px] text-slate-500">
                        Designed for Envato-style licensing flows.
                    </span>
                </div>
            </div>
        </section>

        <!-- Core Concept -->
        <section id="core-concept" class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-mono uppercase tracking-[0.25em] text-sky-400/80">
                        Core Concept
                    </p>
                    <h3 class="mt-1 text-2xl font-semibold tracking-tight">
                        WordPress Plugins ที่เริ่มจากคำถามว่า &ldquo;ปัญหาคืออะไรแน่ๆ?&rdquo;
                    </h3>
                </div>
                <p class="max-w-xl text-sm text-slate-300">
                    ทุกปลั๊กอินใน Overconda Lab ถูกออกแบบแบบ <span class="text-sky-300">Problem-Solving First</span>:
                    แยกสัญญาณออกจาก Noise, มองเห็นต้นตอปัญหา WordPress site ให้ชัด แล้วค่อยลงมือแก้ด้วยวิธีที่ปลอดภัยและวัดผลได้.
                </p>
            </div>
            <div class="grid gap-5 md:grid-cols-3">
                <article class="rounded-2xl border border-slate-800 bg-slate-900/60 p-4 space-y-2">
                    <p class="text-xs font-mono text-sky-300/90">01 · Deep Problem Scanning</p>
                    <h4 class="text-sm font-semibold">มองเห็นปัญหา ก่อนล้มทั้ง Site</h4>
                    <p class="text-xs text-slate-400">
                        ใช้แนวคิด Observability + Logging เพื่อช่วย Dev, Admin และ Agency
                        แยกแยะว่าปัญหามาจาก Plugin, Theme หรือ Hosting layer.
                    </p>
                </article>
                <article class="rounded-2xl border border-slate-800 bg-slate-900/60 p-4 space-y-2">
                    <p class="text-xs font-mono text-sky-300/90">02 · Native WordPress First</p>
                    <h4 class="text-sm font-semibold">เล่นกับ WordPress Core อย่างเคารพ</h4>
                    <p class="text-xs text-slate-400">
                        เคารพ Hook, Filter, Capability และ Security model ของ WordPress
                        เพื่อไม่สร้าง Technical Debt หรือ Side Effect แปลกๆ ให้ลูกค้า.
                    </p>
                </article>
                <article class="rounded-2xl border border-slate-800 bg-slate-900/60 p-4 space-y-2">
                    <p class="text-xs font-mono text-sky-300/90">03 · Maintainable &amp; Observable</p>
                    <h4 class="text-sm font-semibold">ออกแบบเพื่อ Scale และ Support ระยะยาว</h4>
                    <p class="text-xs text-slate-400">
                        โครงสร้างโค้ดแยกชั้นชัดเจน พร้อมต่อยอดเป็น SaaS, License Server
                        และระบบ Support ที่เชื่อมกับ Marketplace อย่าง Envato ได้.
                    </p>
                </article>
            </div>
        </section>

        <!-- Our WordPress Plugins -->
        <section id="plugins" class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-mono uppercase tracking-[0.25em] text-emerald-400/80">
                        Our WordPress Plugins
                    </p>
                    <h3 class="mt-1 text-2xl font-semibold tracking-tight">
                        Tools จาก Overconda Lab สำหรับ Dev, Agency และ Site Owner
                    </h3>
                </div>
                <p class="max-w-md text-xs md:text-sm text-slate-300">
                    ทุก Card ด้านล่างถูกเรนเดอร์จาก <span class="font-mono text-slate-100">$plugins</span> array
                    เพื่อให้เพิ่ม Plugin ใหม่ได้ง่ายในอนาคต – แค่เพิ่มข้อมูลใน PHP ก็พอ.
                </p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($plugins as $plugin): ?>
                    <?php
                        $name = (string) ($plugin['name'] ?? 'Untitled Plugin');
                        $description = (string) ($plugin['description'] ?? '');
                        $badge = (string) ($plugin['badge'] ?? '');
                        $badgeVariant = (string) ($plugin['badge_variant'] ?? 'emerald');
                        $tags = is_array($plugin['tags'] ?? null) ? $plugin['tags'] : [];

                        $badgeColors = [
                            'emerald' => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/40',
                            'sky' => 'bg-sky-500/10 text-sky-300 border-sky-500/40',
                            'amber' => 'bg-amber-500/10 text-amber-300 border-amber-500/40',
                        ];
                        $badgeClass = $badgeColors[$badgeVariant] ?? $badgeColors['emerald'];
                    ?>
                    <article class="group rounded-2xl border border-slate-800/80 bg-slate-950/60 hover:border-cyan-500/80 hover:bg-slate-900/80 transition overflow-hidden flex flex-col">
                        <div class="relative overflow-hidden">
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-tr from-cyan-500/10 via-sky-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="aspect-[16/6] bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 border-b border-slate-800/80 flex items-center justify-between px-4 py-3">
                                <div class="space-y-1">
                                    <p class="text-[11px] font-mono uppercase tracking-[0.2em] text-slate-500">
                                        WP Plugin · Problem Solver
                                    </p>
                                    <h4 class="text-sm md:text-base font-semibold line-clamp-2">
                                        <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>
                                    </h4>
                                </div>
                                <?php if ($badge !== ''): ?>
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-medium border <?php echo htmlspecialchars($badgeClass, ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars($badge, ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="p-4 flex flex-col gap-3 flex-1">
                            <?php if ($description !== ''): ?>
                                <p class="text-xs text-slate-300 leading-relaxed line-clamp-4">
                                    <?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($tags)): ?>
                                <div class="flex flex-wrap gap-1.5 mt-1">
                                    <?php foreach ($tags as $tag): ?>
                                        <span class="inline-flex items-center rounded-full bg-slate-900/80 px-2 py-0.5 text-[10px] text-slate-300 border border-slate-700/80">
                                            <?php echo htmlspecialchars((string) $tag, ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="mt-auto pt-2 flex items-center justify-between gap-2 text-[11px] text-slate-400">
                                <span class="inline-flex items-center gap-1">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400/90"></span>
                                    Focus on conflict detection workflow
                                </span>
                                <span class="hidden sm:inline-flex items-center gap-1 text-slate-500">
                                    <span class="h-1 w-1 rounded-full bg-slate-600"></span>
                                    PHP · WordPress Hooks
                                </span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="border-t border-slate-800 pt-8 space-y-3">
            <h3 class="text-xl font-semibold tracking-tight">Contact &amp; Collaboration</h3>
            <p class="text-sm text-slate-300">
                สนใจร่วมงาน, ทำ Plugin ร่วมกัน หรืออยากให้ช่วย Debug ปัญหา WordPress / Hosting แบบลึกๆ
                สามารถติดต่อ Overconda ได้ผ่านช่องทางด้านล่าง.
            </p>
            <div class="flex flex-wrap gap-3 text-sm text-slate-200">
                <a
                    href="mailto:hello@overconda.online"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-700 px-4 py-1.5 hover:border-cyan-400 hover:text-cyan-200 transition"
                >
                    <span class="text-base">✉</span>
                    hello@overconda.online
                </a>
                <a
                    href="https://www.youtube.com/@Overconda"
                    target="_blank"
                    rel="noreferrer"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-700 px-4 py-1.5 hover:border-cyan-400 hover:text-cyan-200 transition"
                >
                    YouTube · Overconda
                </a>
                <a
                    href="https://x.com/overconda"
                    target="_blank"
                    rel="noreferrer"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-700 px-4 py-1.5 hover:border-cyan-400 hover:text-cyan-200 transition"
                >
                    X (Twitter) · @overconda
                </a>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-800 bg-slate-950/90">
        <div class="max-w-6xl mx-auto px-4 py-4 text-[11px] text-slate-500 flex flex-col md:flex-row justify-between gap-2">
            <span>&copy; <?php echo date('Y'); ?> Overconda Lab. All rights reserved.</span>
            <div class="flex flex-wrap gap-3 items-center">
                <a
                    href="/license-validation.php"
                    class="inline-flex items-center gap-1 rounded-full border border-slate-700 px-2.5 py-1 hover:border-cyan-400 hover:text-cyan-200 transition"
                >
                    License Validation
                </a>
                <span>Built with PHP &amp; Tailwind CSS · Optimized for WordPress products.</span>
            </div>
        </div>
    </footer>
</body>
</html>

